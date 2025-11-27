<?php

namespace App\Console\Commands;

use App\Models\Live\StasisCDR as LiveStasisCDR;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Live\StasisStartEvent;
use App\Models\Live\StasisEndEvent;
use Carbon\Carbon;

class StasisCDRpopulate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cdr:process {--from= : Start date (YYYY-MM-DD) for a historical backfill run. If omitted, uses incremental logic.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes raw Stasis events to generate and persist Call Detail Records (CDR) incrementally or historically.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting CDR data processing...');

        // --- Configuration ---
        $inbound_trunk_prefix = 'PJSIP/alice%';
        $abandonment_threshold_seconds = 15;
        $time_end = Carbon::now()->toDateTimeString();

        // 1. DYNAMIC DATE RANGE DETERMINATION
        if ($this->option('from')) {
            // --- BACKFILL MODE ---
            // If the --from option is provided, process all data from that date until now.
            $time_start = Carbon::parse($this->option('from'))->startOfDay()->toDateTimeString();
            $this->comment("Running in HISTORICAL BACKFILL MODE from {$time_start} to {$time_end}.");
        } else {
            // --- INCREMENTAL MODE (Default for cron) ---
            // Find the latest processed time in the CDR table to start from.
            $latestCdrTime = LiveStasisCDR::max('start_time');

            if ($latestCdrTime) {
                // Start 5 minutes before the last processed time to catch any stragglers or late-arriving events.
                $time_start = Carbon::parse($latestCdrTime)->subMinutes(5)->toDateTimeString();
                $this->comment("Running in INCREMENTAL MODE. Starting from last record time (with 5 min look-back).");
            } else {
                // First run: Find the absolute earliest event to process everything from the beginning.
                $firstEvent = StasisStartEvent::min('timestamp');
                if (!$firstEvent) {
                    $this->comment('No Stasis events found. Skipping CDR processing.');
                    return 0;
                }
                $time_start = Carbon::parse($firstEvent)->startOfDay()->toDateTimeString();
                $this->comment("Running FIRST-TIME MODE. Starting from the earliest event: {$time_start}.");
            }
        }

        $this->comment("Processing window: {$time_start} to {$time_end}");

        // 2. Fetch all unique inbound calls (StasisStart events in Ring state on the trunk)
        $callerStartEvents = StasisStartEvent::where('channel_name', 'like', $inbound_trunk_prefix)
            ->where('channel_state', 'Ring')
            ->whereBetween('timestamp', [$time_start, $time_end])
            // Optimization: If running historically, we can limit the data to records not yet in StasisCDR.
            // However, updateOrCreate handles this fine, so we proceed with the time range filter.
            ->get();

        $totalAttempts = $callerStartEvents->count();
        $this->info("Found {$totalAttempts} new/unprocessed inbound call attempts.");

        if ($totalAttempts === 0) {
            $this->comment('No relevant inbound calls found in the time window.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($totalAttempts);
        $progressBar->start();
        $processedCount = 0;

        // 3. Process each call attempt to determine its fate and metrics
        foreach ($callerStartEvents as $callerStart) {

            // Look for a corresponding ANSWER (StasisStart with 'Up') event
            // Linked via the caller's channel_id stored in the callee's args[2]
            $calleeAnswer = StasisStartEvent::where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(args, "$[2]"))'), $callerStart->channel_id)
                ->where('channel_state', 'Up')
                ->where('channel_name', 'not like', $inbound_trunk_prefix)
                ->first();

            // Look for a corresponding HANGUP (StasisEnd) event on the caller's channel
            $callerEnd = StasisEndEvent::where('channel_id', $callerStart->channel_id)->first();

            // --- Determine Timestamps and Classification ---
            $isAnswered = (bool)$calleeAnswer;
            $answerTime = $calleeAnswer ? Carbon::parse($calleeAnswer->timestamp) : null;
            $endTime = $callerEnd ? Carbon::parse($callerEnd->timestamp) : null;
            $startTime = Carbon::parse($callerStart->timestamp);

            $timeToAnswerSeconds = $isAnswered ? $answerTime->diffInSeconds($startTime) : null;
            $talkTimeSeconds = ($isAnswered && $endTime) ? $endTime->diffInSeconds($answerTime) : null;
            $ringDurationSeconds = $endTime ? $endTime->diffInSeconds($startTime) : null;

            // --- Extract Recording File Name ---
            // This relies on the `recording_file_name` accessor in the StasisStartEvent model
            $recordingFileName = $callerStart->recording_file_name;

            // --- Classification Logic ---
            $isAbandoned = false;
            $isShortMiss = false;

            if (!$isAnswered) {
                if ($ringDurationSeconds !== null && $ringDurationSeconds >= $abandonment_threshold_seconds) {
                    $isAbandoned = true;
                } else {
                    $isShortMiss = true;
                }
            }

            // --- Insert or Update the Call Detail Record (CDR) ---
            LiveStasisCDR::updateOrCreate(
                ['caller_channel_id' => $callerStart->channel_id],
                [
                    'stasis_start_event_id' => $callerStart->id,
                    'stasis_end_event_id' => $callerEnd ? $callerEnd->id : null,
                    'callee_channel_id' => $calleeAnswer ? $calleeAnswer->channel_id : null,
                    'caller_number' => $callerStart->caller_number,
                    'file_name' => $recordingFileName, // <-- New field insertion
                    'start_time' => $startTime,
                    'answer_time' => $answerTime,
                    'end_time' => $endTime,
                    'agent_name' => $calleeAnswer ? $calleeAnswer->caller_name : null,
                    'agent_extension' => $calleeAnswer ? explode('-', $calleeAnswer->channel_name)[0] : null,
                    'is_answered' => $isAnswered,
                    'is_abandoned' => $isAbandoned,
                    'is_short_miss' => $isShortMiss,
                    'ring_duration_seconds' => $ringDurationSeconds,
                    'time_to_answer_seconds' => $timeToAnswerSeconds,
                    'talk_time_seconds' => $talkTimeSeconds,
                ]
            );
            $processedCount++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
        $this->info("CDR processing complete. Total records created/updated: {$processedCount}");

        return 0; // Success code
    }
}
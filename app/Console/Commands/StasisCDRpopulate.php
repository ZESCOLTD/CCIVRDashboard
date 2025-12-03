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
    protected $description = 'Processes raw Stasis events to generate and persist Call Detail Records (CDR) efficiently, incrementally or historically.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting CDR data processing...');

        // --- Configuration ---
        // Prefix to identify the main inbound trunk channels (e.g., PJSIP/provider-name-channel-XXXX)
        $inbound_trunk_prefix = 'PJSIP/alice%';
        // The duration in seconds after which an un-answered call is classified as "Abandoned"
        $abandonment_threshold_seconds = 15;
        $time_end = Carbon::now()->toDateTimeString();

        // 1. DYNAMIC DATE RANGE DETERMINATION
        if ($this->option('from')) {
            // --- BACKFILL MODE ---
            $time_start = Carbon::parse($this->option('from'))->startOfDay()->toDateTimeString();
            $this->comment("Running in HISTORICAL BACKFILL MODE from {$time_start} to {$time_end}.");
        } else {
            // --- INCREMENTAL MODE (Default for cron) ---
            $latestCdrTime = LiveStasisCDR::max('start_time');

            if ($latestCdrTime) {
                // Look back 15 minutes to catch any events that arrived late or were incomplete in the last run.
                $time_start = Carbon::parse($latestCdrTime)->subMinutes(15)->toDateTimeString();
                $this->comment("Running in INCREMENTAL MODE. Starting from last record time (with 15 min look-back).");
            } else {
                // First run
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

        // 2. Define the base query for all unique inbound calls and count total attempts
        $callerStartQuery = StasisStartEvent::where('channel_name', 'like', $inbound_trunk_prefix)
            ->where('channel_state', 'Ring')
            ->whereBetween('timestamp', [$time_start, $time_end])
            // ** NEW OPTIMIZATION: Skip records that already exist in the CDR table **
            ->whereNotIn('channel_id', function ($query) {
                $query->select('caller_channel_id')
                      ->from((new LiveStasisCDR)->getTable());
            })
            // Must order by ID for chunkById to work correctly
            ->orderBy('id');

        // Note: Counting the total attempts is generally fast, but the following chunking prevents memory exhaustion.
        $totalAttempts = $callerStartQuery->count();
        $this->info("Found {$totalAttempts} new/unprocessed inbound call attempts.");

        if ($totalAttempts === 0) {
            $this->comment('No relevant inbound calls found in the time window.');
            return 0;
        }

        $progressBar = $this->output->createProgressBar($totalAttempts);
        $progressBar->start();
        $processedCount = 0;
        $chunkSize = 1000; // Process 1,000 records at a time

        // 3. Process records in chunks (MEMORY OPTIMIZATION)
        // This replaces the $callerStartEvents->get() call and the main foreach loop.
        $callerStartQuery->chunkById($chunkSize, function ($callerStartChunk) use (
            $time_start, $time_end, $inbound_trunk_prefix, $abandonment_threshold_seconds,
            &$progressBar, &$processedCount
        ) {
            // Get all channel IDs for the current chunk
            $channelIdsToProcess = $callerStartChunk->pluck('channel_id')->toArray();

            // OPTIMIZATION: Bulk fetch required END and ANSWER events for the current chunk only.
            // This prevents loading all 14k+ events into memory at once.
            $callerEndEvents = StasisEndEvent::whereIn('channel_id', $channelIdsToProcess)
                ->whereBetween('timestamp', [$time_start, $time_end])
                ->get()
                ->keyBy('channel_id');

            // Pre-fetch all ANSWER events (StasisStart 'Up')
            $calleeAnswerEvents = StasisStartEvent::where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(args, "$[2]"))'), 'IN', $channelIdsToProcess)
                ->where('channel_state', 'Up')
                ->where('channel_name', 'not like', $inbound_trunk_prefix)
                ->whereBetween('timestamp', [$time_start, $time_end])
                ->get()
                // Key the collection by the caller's channel_id (which is args[2]) for fast lookup
                ->keyBy(function ($item) {
                    return json_decode($item->args)[2] ?? null;
                });

            // 4. Process each call attempt in the current chunk
            foreach ($callerStartChunk as $callerStart) {
                $callerChannelId = $callerStart->channel_id;
                $startTime = Carbon::parse($callerStart->timestamp);

                // In-memory lookup: Find the corresponding ANSWER
                $calleeAnswer = $calleeAnswerEvents->get($callerChannelId);

                // In-memory lookup: Find the corresponding HANGUP
                $callerEnd = $callerEndEvents->get($callerChannelId);

                // --- Determine Timestamps and Classification ---
                $isAnswered = (bool)$calleeAnswer;
                $answerTime = $calleeAnswer ? Carbon::parse($calleeAnswer->timestamp) : null;
                $endTime = $callerEnd ? Carbon::parse($callerEnd->timestamp) : null;

                // Ensure durations are calculated, even if they result in null
                $timeToAnswerSeconds = ($isAnswered && $answerTime) ? $answerTime->diffInSeconds($startTime) : null;
                $talkTimeSeconds = ($isAnswered && $endTime) ? $endTime->diffInSeconds($answerTime) : null;
                $ringDurationSeconds = $endTime ? $endTime->diffInSeconds($startTime) : null;

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

                // --- Extract Agent/Recording Data ---
                $recordingFileName = $calleeAnswer->recording_file_name ?? null;
                $agentExtension = null;
                if ($calleeAnswer) {
                    // Safely extract extension, assuming the format is EXTENSION-UNIQUEID
                    $parts = explode('-', $calleeAnswer->channel_name);
                    $agentExtension = $parts[0] ?? null;
                }

                // --- Define the data payload to save/update ---
                $cdrData = [
                    'stasis_start_event_id' => $callerStart->id,
                    'caller_number' => $callerStart->caller_number,
                    'caller_channel_id' => $callerChannelId, // Explicitly set the key for the CDR table
                    'start_time' => $startTime,
                    'is_answered' => $isAnswered,
                    'is_abandoned' => $isAbandoned,
                    'is_short_miss' => $isShortMiss,

                    'stasis_end_event_id' => $callerEnd ? $callerEnd->id : null,
                    'callee_channel_id' => $calleeAnswer ? $calleeAnswer->channel_id : null,
                    'file_name' => $recordingFileName,
                    'answer_time' => $answerTime,
                    'end_time' => $endTime,
                    'agent_name' => $calleeAnswer ? $calleeAnswer->caller_name : null,
                    'agent_extension' => $agentExtension,
                    'ring_duration_seconds' => $ringDurationSeconds,
                    'time_to_answer_seconds' => $timeToAnswerSeconds,
                    'talk_time_seconds' => $talkTimeSeconds,
                ];

                // Since we used whereNotIn above, this will almost always be a new record.
                // We keep firstOrNew for safety/idempotence.
                $cdr = LiveStasisCDR::firstOrNew(['caller_channel_id' => $callerChannelId]);

                // Fill the model with the prepared data payload and save
                $cdr->fill($cdrData);
                $cdr->save();

                $processedCount++;
                $progressBar->advance();
            }
        }); // End of chunkById

        $progressBar->finish();
        $this->newLine();
        $this->info("CDR processing complete. Total records created/updated: {$processedCount}");

        return 0; // Success code
    }
}
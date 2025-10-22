<?php

namespace Database\Seeders;

use App\Models\Live\StasisCDR;
use App\Models\Live\StasisEndEvent;
use App\Models\Live\StasisStartEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// class CDRSeeder extends Seeder
// {
//     /**
//      * Run the database seeds to populate the CDR table from raw event logs.
//      */
//     public function run(): void
//     {
//         // --- Configuration (Matches the Livewire Component) ---
//         $inbound_trunk_prefix = 'PJSIP/alice%';
//         $abandonment_threshold_seconds = 15;
//         // Use a fixed time window for seeding efficiency, adjust as needed
//         $time_start = Carbon::create(2025, 10, 17, 10, 0, 0);
//         $time_end = Carbon::create(2025, 10, 17, 14, 0, 0);

//         // Ensure the CDR table is clean before seeding new data
//         StasisCDR::truncate();

//         // 1. Fetch all unique inbound calls (StasisStart events in Ring state on the trunk)
//         $callerStartEvents = StasisStartEvent::where('channel_name', 'like', $inbound_trunk_prefix)
//             ->where('channel_state', 'Ring')
//             ->whereBetween('timestamp', [$time_start, $time_end])
//             ->get();

//         $totalAttempts = $callerStartEvents->count();
//         $this->command->info("Processing {$totalAttempts} inbound call attempts...");

//         // --- PROGRESS BAR INITIALIZATION ---
//         $progressBar = $this->command->getOutput()->createProgressBar($totalAttempts);
//         $progressBar->start();

//         // 2. Process each call attempt to determine its fate and metrics
//         foreach ($callerStartEvents as $callerStart) {

//             // Look for a corresponding ANSWER (StasisStart with 'Up') event
//             // Linked via the caller's channel_id stored in the callee's args[2]
//             $calleeAnswer = StasisStartEvent::where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(args, "$[2]"))'), $callerStart->channel_id)
//                 ->where('channel_state', 'Up')
//                 ->where('channel_name', 'not like', $inbound_trunk_prefix)
//                 ->first();

//             // Look for a corresponding HANGUP (StasisEnd) event on the caller's channel
//             $callerEnd = StasisEndEvent::where('channel_id', $callerStart->channel_id)->first();

//             // --- Determine Timestamps and Classification ---

//             $isAnswered = (bool)$calleeAnswer;
//             $answerTime = $calleeAnswer ? $calleeAnswer->timestamp : null;
//             $endTime = $callerEnd ? $callerEnd->timestamp : null;
//             $startTime = $callerStart->timestamp;

//             $timeToAnswerSeconds = $isAnswered ? $answerTime->diffInSeconds($startTime) : null;
//             $talkTimeSeconds = ($isAnswered && $endTime) ? $endTime->diffInSeconds($answerTime) : null;
//             $ringDurationSeconds = $endTime ? $endTime->diffInSeconds($startTime) : null;

//             // --- Classification Logic ---
//             $isAbandoned = false;
//             $isShortMiss = false;

//             if (!$isAnswered) {
//                 if ($ringDurationSeconds !== null && $ringDurationSeconds >= $abandonment_threshold_seconds) {
//                     $isAbandoned = true;
//                 } else {
//                     // This covers two cases:
//                     // 1. Caller hung up quickly (ringDurationSeconds < threshold)
//                     // 2. Call is still ringing (endTime is null)
//                     $isShortMiss = true;
//                 }
//             }

//             // --- Insert or Update the Call Detail Record (CDR) ---
//             StasisCDR::updateOrCreate(
//                 ['caller_channel_id' => $callerStart->channel_id],
//                 [
//                     // CLOSURE KEYS
//                     'stasis_start_event_id' => $callerStart->id,
//                     'stasis_end_event_id' => $callerEnd ? $callerEnd->id : null,

//                     // CORE IDENTIFIERS
//                     'callee_channel_id' => $calleeAnswer ? $calleeAnswer->channel_id : null,
//                     'caller_number' => $callerStart->caller_number,

//                     // TIMESTAMPS
//                     'start_time' => $startTime,
//                     'answer_time' => $answerTime,
//                     'end_time' => $endTime,

//                     // AGENT INFO
//                     'agent_name' => $calleeAnswer ? $calleeAnswer->caller_name : null,
//                     'agent_extension' => $calleeAnswer ? explode('-', $calleeAnswer->channel_name)[0] : null,

//                     // CLASSIFICATION FLAGS
//                     'is_answered' => $isAnswered,
//                     'is_abandoned' => $isAbandoned,
//                     'is_short_miss' => $isShortMiss,

//                     // CALCULATED DURATIONS
//                     'ring_duration_seconds' => $ringDurationSeconds,
//                     'time_to_answer_seconds' => $timeToAnswerSeconds,
//                     'talk_time_seconds' => $talkTimeSeconds,
//                 ]
//             );

//             // --- Advance Progress Bar ---
//             $progressBar->advance();
//         }

//         // --- Finish Progress Bar ---
//         $progressBar->finish();
//         $this->command->newLine(); // Add a newline after the bar

//         $this->command->info("CDR table population complete. Total records processed: {$totalAttempts}");
//     }
// }

// class CDRSeeder extends Seeder
// {
//     /**
//      * Run the database seeds to populate the CDR table from raw event logs.
//      */
//     public function run(): void
//     {
//         // --- Configuration (Matches the Livewire Component) ---
//         $inbound_trunk_prefix = 'PJSIP/alice%';
//         $abandonment_threshold_seconds = 15;
//         // Use a fixed time window for seeding efficiency, adjust as needed
//         $time_start = Carbon::create(2025, 10, 17, 10, 0, 0);
//         $time_end = Carbon::create(2025, 10, 17, 14, 0, 0);

//         // Ensure the CDR table is clean before seeding new data
//         StasisCDR::truncate();

//         // 1. Fetch all unique inbound calls (StasisStart events in Ring state on the trunk)
//         $callerStartEvents = StasisStartEvent::where('channel_name', 'like', $inbound_trunk_prefix)
//             ->where('channel_state', 'Ring')
//             ->whereBetween('timestamp', [$time_start, $time_end])
//             ->get();

//         $totalAttempts = $callerStartEvents->count();
//         $this->command->info("Processing {$totalAttempts} inbound call attempts...");

//         // --- PROGRESS BAR INITIALIZATION ---
//         $progressBar = $this->command->getOutput()->createProgressBar($totalAttempts);
//         $progressBar->start();

//         // 2. Process each call attempt to determine its fate and metrics
//         foreach ($callerStartEvents as $callerStart) {

//             // Look for a corresponding ANSWER (StasisStart with 'Up') event
//             // Linked via the caller's channel_id stored in the callee's args[2]
//             $calleeAnswer = StasisStartEvent::where(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(args, "$[2]"))'), $callerStart->channel_id)
//                 ->where('channel_state', 'Up')
//                 ->where('channel_name', 'not like', $inbound_trunk_prefix)
//                 ->first();

//             // Look for a corresponding HANGUP (StasisEnd) event on the caller's channel
//             $callerEnd = StasisEndEvent::where('channel_id', $callerStart->channel_id)->first();

//             // --- Determine Timestamps and Classification ---

//             $isAnswered = (bool)$calleeAnswer;
//             $answerTime = $calleeAnswer ? $calleeAnswer->timestamp : null;
//             $endTime = $callerEnd ? $callerEnd->timestamp : null;
//             $startTime = $callerStart->timestamp;

//             $timeToAnswerSeconds = $isAnswered ? $answerTime->diffInSeconds($startTime) : null;
//             $talkTimeSeconds = ($isAnswered && $endTime) ? $endTime->diffInSeconds($answerTime) : null;
//             $ringDurationSeconds = $endTime ? $endTime->diffInSeconds($startTime) : null;

//             // --- Classification Logic ---
//             $isAbandoned = false;
//             $isShortMiss = false;

//             if (!$isAnswered) {
//                 if ($ringDurationSeconds !== null && $ringDurationSeconds >= $abandonment_threshold_seconds) {
//                     $isAbandoned = true;
//                 } else {
//                     // This covers two cases:
//                     // 1. Caller hung up quickly (ringDurationSeconds < threshold)
//                     // 2. Call is still ringing (endTime is null)
//                     $isShortMiss = true;
//                 }
//             }

//             // --- Check for existence (by caller_channel_id) and ONLY INSERT if new ---
//             StasisCDR::firstOrCreate(
//                 ['caller_channel_id' => $callerStart->channel_id], // Lookup criteria
//                 [
//                     // CLOSURE KEYS
//                     'stasis_start_event_id' => $callerStart->id,
//                     'stasis_end_event_id' => $callerEnd ? $callerEnd->id : null,

//                     // CORE IDENTIFIERS (Including the lookup key for creation)
//                     'caller_channel_id' => $callerStart->channel_id,
//                     'callee_channel_id' => $calleeAnswer ? $calleeAnswer->channel_id : null,
//                     'caller_number' => $callerStart->caller_number,

//                     // TIMESTAMPS
//                     'start_time' => $startTime,
//                     'answer_time' => $answerTime,
//                     'end_time' => $endTime,

//                     // AGENT INFO
//                     'agent_name' => $calleeAnswer ? $calleeAnswer->caller_name : null,
//                     'agent_extension' => $calleeAnswer ? explode('-', $calleeAnswer->channel_name)[0] : null,

//                     // CLASSIFICATION FLAGS
//                     'is_answered' => $isAnswered,
//                     'is_abandoned' => $isAbandoned,
//                     'is_short_miss' => $isShortMiss,

//                     // CALCULATED DURATIONS
//                     'ring_duration_seconds' => $ringDurationSeconds,
//                     'time_to_answer_seconds' => $timeToAnswerSeconds,
//                     'talk_time_seconds' => $talkTimeSeconds,
//                 ]
//             );

//             // --- Advance Progress Bar ---
//             $progressBar->advance();
//         }

//         // --- Finish Progress Bar ---
//         $progressBar->finish();
//         $this->command->newLine(); // Add a newline after the bar

//         $this->command->info("CDR table population complete. Total records processed: {$totalAttempts}");
//     }
// }

class CDRSeeder extends Seeder
{
    /**
     * Run the database seeds to populate the CDR table from raw event logs.
     */
    public function run(): void
    {
        // --- Configuration (Matches the Livewire Component) ---
        $inbound_trunk_prefix = 'PJSIP/alice%';
        $abandonment_threshold_seconds = 15;
        // Use a fixed time window for seeding efficiency, adjust as needed
        $time_start = Carbon::create(2025, 10, 21, 14, 0, 0);
        $time_end = Carbon::create(2025, 10, 21, 22, 0, 0);

        // Ensure the CDR table is clean before seeding new data
        // NOTE: In a production job, you would typically only process new events,
        // but for a seeder, truncation is safe.
        StasisCDR::truncate();

        // 1. Fetch all unique inbound calls (StasisStart events in Ring state on the trunk)
        $callerStartEvents = StasisStartEvent::where('channel_name', 'like', $inbound_trunk_prefix)
            ->where('channel_state', 'Ring')
            ->whereBetween('timestamp', [$time_start, $time_end])
            ->get();

        $totalAttempts = $callerStartEvents->count();
        $this->command->info("Processing {$totalAttempts} inbound call attempts...");

        // --- PROGRESS BAR INITIALIZATION ---
        $progressBar = $this->command->getOutput()->createProgressBar($totalAttempts);
        $progressBar->start();

        // 2. Process each call attempt to determine its fate and metrics
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
            $answerTime = $calleeAnswer ? $calleeAnswer->timestamp : null;
            $endTime = $callerEnd ? $callerEnd->timestamp : null;
            $startTime = $callerStart->timestamp;

            $timeToAnswerSeconds = $isAnswered ? $answerTime->diffInSeconds($startTime) : null;
            $talkTimeSeconds = ($isAnswered && $endTime) ? $endTime->diffInSeconds($answerTime) : null;
            $ringDurationSeconds = $endTime ? $endTime->diffInSeconds($startTime) : null;

            // --- Classification Logic ---
            $isAbandoned = false;
            $isShortMiss = false;

            if (!$isAnswered) {
                if ($ringDurationSeconds !== null && $ringDurationSeconds >= $abandonment_threshold_seconds) {
                    $isAbandoned = true;
                } else {
                    // This covers two cases:
                    // 1. Caller hung up quickly (ringDurationSeconds < threshold)
                    // 2. Call is still ringing (endTime is null)
                    $isShortMiss = true;
                }
            }

            // --- Check for existence (by caller_channel_id) and ONLY INSERT if new ---
            StasisCDR::firstOrCreate(
                ['caller_channel_id' => $callerStart->channel_id], // Lookup criteria
                [
                    // CLOSURE KEYS
                    'stasis_start_event_id' => $callerStart->id,
                    'stasis_end_event_id' => $callerEnd ? $callerEnd->id : null,

                    // CORE IDENTIFIERS (Including the lookup key for creation)
                    'caller_channel_id' => $callerStart->channel_id,
                    'callee_channel_id' => $calleeAnswer ? $calleeAnswer->channel_id : null,
                    'caller_number' => $callerStart->caller_number,

                    // TIMESTAMPS
                    'start_time' => $startTime,
                    'answer_time' => $answerTime,
                    'end_time' => $endTime,

                    // AGENT INFO
                    'agent_name' => $calleeAnswer ? $calleeAnswer->caller_name : null,
                    'agent_extension' => $calleeAnswer ? explode('-', $calleeAnswer->channel_name)[0] : null,

                    // CLASSIFICATION FLAGS
                    'is_answered' => $isAnswered,
                    'is_abandoned' => $isAbandoned,
                    'is_short_miss' => $isShortMiss,

                    // CALCULATED DURATIONS
                    'ring_duration_seconds' => $ringDurationSeconds,
                    'time_to_answer_seconds' => $timeToAnswerSeconds,
                    'talk_time_seconds' => $talkTimeSeconds,
                ]
            );

            // --- Advance Progress Bar ---
            $progressBar->advance();
        }

        // --- Finish Progress Bar ---
        $progressBar->finish();
        $this->command->newLine(); // Add a newline after the bar

        $this->command->info("CDR table population complete. Total records processed: {$totalAttempts}");

        // --- Step 3: Report Final Metrics from the newly populated CDR table (The FAST query) ---
        $this->command->newLine();
        $this->command->info('--- Final Metrics Verification (from StasisCDR table) ---');
        $this->command->comment('This query is representative of how your Livewire component now runs.');

        $finalMetrics = StasisCDR::query()
            ->select(
                DB::raw('SUM(is_answered) as answered_calls'),
                DB::raw('SUM(is_abandoned) as abandoned_calls'),
                DB::raw('SUM(is_short_miss) as short_missed_calls')
            )
            ->first();

        $this->command->table(
            ['Metric', 'Count'],
            [
                ['Total Answered Calls', $finalMetrics->answered_calls ?? 0],
                ['Total Abandoned Calls', $finalMetrics->abandoned_calls ?? 0],
                ['Total Short Missed/Ringing Calls', $finalMetrics->short_missed_calls ?? 0],
                ['Total Call Attempts (Inferred from loop)', $totalAttempts],
            ]
        );
        $this->command->info('----------------------------------------------------------');
    }
}
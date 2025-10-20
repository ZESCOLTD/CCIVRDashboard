<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisCDR;
use App\Models\Live\StasisEndEvent;
use App\Models\Live\StasisStartEvent;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StasisStartEventComponent extends Component
{
    //     public function render()
    //     {
    // //         $answered = StasisStartEvent::from('stasis_start_events as callers')
    // //     ->join('stasis_start_events as callees', function ($join) {
    // //         $join->on('callers.caller_number', '=', 'callees.caller_number')
    // //              ->where('callees.channel_name', 'like', 'PJSIP/%')
    // //              ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
    // //              ->where('callees.channel_state', '=', 'Up');
    // //     })
    // //     ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    // //     ->where('callers.channel_state', '=', 'Ring')
    // //     ->select([
    // //         'callers.caller_number',
    // //         'callers.timestamp as call_time',
    // //         DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) as callee_extension"),
    // //         'callers.channel_name as caller_channel',
    // //         'callees.channel_name as callee_channel',
    // //     ])
    // //     ->get();

    // //     $missed = StasisStartEvent::from('stasis_start_events as callers')
    // //     ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    // //     ->where('callers.channel_state', 'Ring')
    // //     ->whereNotExists(function ($query) {
    // //         $query->select(DB::raw(1))
    // //               ->from('stasis_start_events as callees')
    // //               ->whereRaw('callees.caller_number = callers.caller_number')
    // //               ->where('callees.channel_name', 'like', 'PJSIP/%')
    // //               ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
    // //               ->where('callees.channel_state', '=', 'Up');
    // //     })
    // //     ->select([
    // //         'callers.caller_number',
    // //         'callers.timestamp as call_time',
    // //         DB::raw("SUBSTRING_INDEX(callers.channel_name, '-', 1) as caller_channel"),
    // //     ])
    // //     ->get();

    // //     $abandoned = StasisStartEvent::from('stasis_start_events as callers')
    // //     ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    // //     ->where('callers.channel_state', '=', 'Ring')
    // //     ->whereNotExists(function ($query) {
    // //         $query->select(DB::raw(1))
    // //               ->from('stasis_start_events as callees')
    // //               ->whereRaw('callers.caller_number = callees.caller_number')
    // //               ->where('callees.channel_name', 'like', 'PJSIP/%')
    // //               ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
    // //               ->where('callees.channel_state', '=', 'Up');
    // //     })
    // //     ->where('callers.timestamp', '<', now()->subSeconds(15)) // abandonment threshold
    // //     ->select([
    // //         'callers.caller_number',
    // //         'callers.timestamp as call_time',
    // //         'callers.channel_name as caller_channel'
    // //     ])
    // //     ->get();

    // //     // dd($answeredCalls, $abandonedCalls, $missedCalls);

    // //     //         // --- Define the Date Range ---
    // // //         // Set the start date/time: October 17, 2025, 10:00:00
    // // //         // --- Define the Date Range (October 17, 2025, 10:00 to 14:00) ---

    // // //         // --- Define the Date Range (October 17, 2025, 10:00 to 14:00) ---
    // //         $startDate = Carbon::create(2025, 10, 17, 10, 0, 0);
    // //         $endDate = Carbon::create(2025, 10, 17, 14, 0, 0);

    // //         $stasisEndEventLog = StasisStartEvent::whereBetween('timestamp', [$startDate, $endDate])
    // //                     ->take(100);

    // //                     // --- Configuration ---
    // // $inbound_trunk_prefix = 'PJSIP/alice%';
    // // $time_start = '2025-10-17 08:00:00Z';
    // // $time_end = '2025-10-17 14:04:00Z';
    // // $abandonment_threshold_seconds = 15;


    // // // 1. ANswered Calls Analysis
    // // // This join uses the explicit channel_id link found in the callee's 'args' field,
    // // // providing the most accurate pairing of the two call legs.
    // // $answered_calls = StasisStartEvent::from('stasis_start_events AS callers')
    // //     ->join('stasis_start_events AS callees', function ($join) use ($inbound_trunk_prefix) {
    // //         // We ensure the callee is an UP agent channel
    // //         $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]"))'), '=', 'callers.channel_id')
    // //              ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    // //              ->where('callees.channel_state', '=', 'Up')
    // //              // Exclude UnicastRTP media channels
    // //              ->where('callees.channel_name', 'like', 'PJSIP/%');
    // //     })
    // //     ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    // //     ->where('callers.channel_state', '=', 'Ring')
    // //     ->whereBetween('callers.timestamp', [$time_start, $time_end])
    // //     ->select([
    // //         'callers.caller_number',
    // //         'callers.timestamp AS ring_time',
    // //         'callees.timestamp AS answer_time',
    // //         'callees.caller_name AS agent_name',
    // //         DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) AS agent_extension"),
    // //         DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, callees.timestamp) AS time_to_answer_seconds"),
    // //     ])
    // //     ->get();


    // // // 2. UNANSWERED/MISSED Calls (Not yet Abandoned)
    // // // These are Ring events that have not been followed by an Up event in the time frame.
    // // $missed_calls = StasisStartEvent::from('stasis_start_events AS callers')
    // //     ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    // //     ->where('callers.channel_state', 'Ring')
    // //     ->whereBetween('callers.timestamp', [$time_start, $time_end])
    // //     ->whereNotExists(function ($query) use ($inbound_trunk_prefix) {
    // //         $query->select(DB::raw(1))
    // //               ->from('stasis_start_events AS callees')
    // //               // Look for a matching answer event (linked by the channel_id)
    // //               ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]")) = callers.channel_id')
    // //               ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    // //               ->where('callees.channel_state', '=', 'Up');
    // //     })
    // //     ->select([
    // //         'callers.caller_number',
    // //         'callers.timestamp AS ring_time',
    // //         DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, NOW()) AS current_ring_duration_seconds"),
    // //     ])
    // //     ->get();


    // // // 3. ABANDONED Calls
    // // // A subset of missed calls where the Ring event occurred before the abandonment threshold.
    // // $abandoned_calls = $missed_calls->filter(function ($call) use ($abandonment_threshold_seconds) {
    // //     // Note: The logic for abandoned calls often requires matching a StasisEnd event
    // //     // that occurs without an intervening 'Up' event. Since we can't see StasisEnd,
    // //     // we use the time-based approximation.
    // //     return $call->current_ring_duration_seconds > $abandonment_threshold_seconds;
    // // });


    // // // --- Outputting the Analysis ---

    // // // Calculate average speed to answer
    // // $total_answered = $answered_calls->count();
    // // $total_answer_time = $answered_calls->sum('time_to_answer_seconds');
    // // $asa = $total_answered > 0 ? $total_answer_time / $total_answered : 0;

    // // dd( "## Call Performance Summary\n",
    // //  "Total Answered Calls: {$total_answered}\n",
    // //  "Average Speed to Answer (ASA): " . number_format($asa, 2) . " seconds\n",
    // //  "Missed Calls (Abandoned or Still Ringing): {$missed_calls->count()}\n\n",

    // // // Example of listing detailed results
    // // "### Detailed Answered Calls\n",
    // // $answered_calls->each(function ($call) {
    // //     echo "- Caller {$call->caller_number} answered by **{$call->agent_name}** ({$call->agent_extension}) in {$call->time_to_answer_seconds}s.\n";
    // // }));

    // // --- Configuration ---
    // $inbound_trunk_prefix = 'PJSIP/alice%';
    // $time_start = '2025-10-17 10:00:00Z'; // Adjusted for new time range
    // $time_end = '2025-10-17 14:04:00Z'; // Adjusted for new time range
    // $abandonment_threshold_seconds = 15; // Standard 15-second abandonment threshold

    // // --- 1. ANSWERED CALLS ANALYSIS (Using robust channel_id linking) ---
    // // This join uses the explicit channel_id link found in the callee's 'args' field,
    // // providing the most accurate pairing of the two call legs.
    // $answered_calls = StasisStartEvent::from('stasis_start_events AS callers')
    //     ->join('stasis_start_events AS callees', function ($join) use ($inbound_trunk_prefix) {
    //         // Link the inbound leg (callers.channel_id) to the callee's 'args' (position 2 in StasisStart args)
    //         $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]"))'), '=', 'callers.channel_id')
    //             // Callee must be an agent channel, not the trunk
    //             ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //             ->where('callees.channel_state', '=', 'Up')
    //             // Exclude non-SIP media channels (e.g., UnicastRTP)
    //             ->where('callees.channel_name', 'like', 'PJSIP/%');
    //     })
    //     ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //     ->where('callers.channel_state', '=', 'Ring')
    //     ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //     ->select([
    //         'callers.caller_number',
    //         'callers.timestamp AS ring_time',
    //         'callees.timestamp AS answer_time',
    //         'callees.caller_name AS agent_name',
    //         DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) AS agent_extension"),
    //         DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, callees.timestamp) AS time_to_answer_seconds"),
    //     ])
    //     // The channel_id link ensures one accurate result per answered call.
    //     ->orderBy('ring_time')
    //     ->get();

    // // --- 2. MISSED CALLS ANALYSIS (Includes Abandoned and Still Ringing) ---
    // // Find Ring events that DO NOT have a subsequent 'Up' event linked via channel_id.
    // $missed_calls = StasisStartEvent::from('stasis_start_events AS callers')
    //     ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //     ->where('callers.channel_state', 'Ring')
    //     ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //     ->whereNotExists(function ($query) use ($inbound_trunk_prefix) {
    //         $query->select(DB::raw(1))
    //               ->from('stasis_start_events AS callees')
    //               // Look for a matching answer event (linked by the channel_id in args)
    //               ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]")) = callers.channel_id')
    //               ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //               ->where('callees.channel_state', '=', 'Up');
    //     })
    //     ->select([
    //         'callers.caller_number',
    //         'callers.timestamp AS ring_time',
    //         DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, NOW()) AS current_ring_duration_seconds"),
    //     ])
    //     ->get();

    // // --- 3. ABANDONED CALLS ANALYSIS ---
    // // Filter the missed calls to only include those that lasted longer than the threshold.
    // $abandoned_calls = $missed_calls->filter(function ($call) use ($abandonment_threshold_seconds) {
    //     // We use the current time (NOW()) as a proxy for the end of the call,
    //     // assuming the call ended sometime before NOW() without being answered/hung up.
    //     return $call->current_ring_duration_seconds > $abandonment_threshold_seconds;
    // });

    // // --- Preparing Final Analysis for dd() ---

    // $total_answered = $answered_calls->count();
    // $total_missed = $missed_calls->count();
    // $total_abandoned = $abandoned_calls->count();
    // $total_calls = $total_answered + $total_missed; // Total attempts in range

    // $total_answer_time = $answered_calls->sum('time_to_answer_seconds');
    // $asa = $total_answered > 0 ? $total_answer_time / $total_answered : 0;

    // $analysis_summary = [
    //     'Configuration' => [
    //         'Time Range Start' => $time_start,
    //         'Time Range End' => $time_end,
    //         'Inbound Trunk Prefix' => $inbound_trunk_prefix,
    //         'Abandonment Threshold (s)' => $abandonment_threshold_seconds,
    //     ],
    //     'Key Metrics' => [
    //         'Total Call Attempts' => $total_calls,
    //         'Total Answered Calls' => $total_answered,
    //         'Total Missed/Still Ringing Calls' => $total_missed,
    //         'Total Abandoned Calls' => $total_abandoned,
    //         'Average Speed to Answer (ASA)' => number_format($asa, 2) . ' seconds',
    //     ],
    //     // Include the collections for deep inspection
    //     'Detailed Collections' => [
    //         'Answered Calls' => $answered_calls,
    //         'Missed Calls (Total)' => $missed_calls,
    //         'Abandoned Calls (> ' . $abandonment_threshold_seconds . 's)' => $abandoned_calls,
    //     ],
    // ];

    // // --- Outputting the Final Analysis using dd() ---
    // dd($analysis_summary);
    //         // $stasisEndEventLog = StasisStartEvent::paginate(10);
    // // dd($stasisEndEventLog);
    //         return view('livewire.live.stasis-start-events-component',[
    //             'stasisEndEventLog' => $stasisEndEventLog,
    //             // 'answered' => $answered,
    //             // 'abandoned' => $abandoned,
    //             // 'missed' => $missed,
    //         ]);
    //     }


    // public function render()
    // {
    //     // Get table names dynamically to ensure accuracy and readability
    //     $stasisStartTable = (new StasisStartEvent())->getTable();
    //     $stasisEndTable = (new StasisEndEvent())->getTable();

    //     // --- Configuration ---
    //     $inbound_trunk_prefix = 'PJSIP/alice%';
    //     $time_start = '2025-10-17 10:00:00Z'; // Time range start (for both start/end events)
    //     $time_end = '2025-10-17 14:04:00Z'; // Time range end
    //     $abandonment_threshold_seconds = 15; // Standard 15-second abandonment threshold

    //     // --- 1. ANSWERED CALLS ANALYSIS (Now includes Talk Time using StasisEndEvent) ---
    //     $answered_calls = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         // Join to find the successful callee leg (The 'Up' event)
    //         ->join("{$stasisStartTable} AS callees", function ($join) use ($inbound_trunk_prefix) {
    //             // Link the inbound leg (callers.channel_id) to the callee's 'args' (position 2 in StasisStart args)
    //             $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]"))'), '=', 'callers.channel_id')
    //                 // Callee must be an agent channel, not the trunk
    //                 ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //                 ->where('callees.channel_state', '=', 'Up')
    //                 // Exclude non-SIP media channels (e.g., UnicastRTP)
    //                 ->where('callees.channel_name', 'like', 'PJSIP/%');
    //         })
    //         // NEW: Join to find the Stasis End event for the *answered* leg to calculate talk time
    //         // We use the dynamic table name and simplified join syntax
    //         ->join("{$stasisEndTable} AS ends", 'ends.channel_id', '=', 'callees.channel_id')

    //         // Filter by caller leg criteria
    //         ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //         ->where('callers.channel_state', '=', 'Ring')
    //         ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //         ->select([
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             'callees.timestamp AS answer_time',
    //             'ends.timestamp AS hangup_time', // The end of the call
    //             'callees.caller_name AS agent_name',
    //             DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) AS agent_extension"),
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, callees.timestamp) AS time_to_answer_seconds"),
    //             DB::raw("TIMESTAMPDIFF(SECOND, callees.timestamp, ends.timestamp) AS talk_time_seconds"), // NEW METRIC
    //         ])
    //         ->orderBy('ring_time')
    //         ->get();

    //     // --- 2. TRUE ABANDONED CALLS (Ring followed by End on caller, NO Up event) ---
    //     $abandoned_calls = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         // Join to find the Stasis End event on the *caller* channel
    //         // We use the dynamic table name and simplified join syntax
    //         ->join("{$stasisEndTable} AS ends", 'ends.channel_id', '=', 'callers.channel_id')

    //         // Filter: Must be an inbound Ring event in the time window
    //         ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //         ->where('callers.channel_state', 'Ring')
    //         ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //         // Ensure it was NOT answered (Same logic as before, checking for an 'Up' event)
    //         ->whereNotExists(function ($query) use ($inbound_trunk_prefix, $stasisStartTable) {
    //             $query->select(DB::raw(1))
    //                   ->from("{$stasisStartTable} AS callees") // Use dynamic table name
    //                   ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]")) = callers.channel_id')
    //                   ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //                   ->where('callees.channel_state', '=', 'Up');
    //         })
    //         // Only include calls that hung up after the abandonment threshold
    //         ->whereRaw("TIMESTAMPDIFF(SECOND, callers.timestamp, ends.timestamp) >= $abandonment_threshold_seconds")
    //         ->select([
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             'ends.timestamp AS hangup_time',
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, ends.timestamp) AS ring_duration_seconds"),
    //         ])
    //         ->get();

    //     // --- 3. SHORT MISSED CALLS / STILL RINGING (Optimized: Unanswered, and NOT True Abandoned) ---
    //     // A call is a short miss or still ringing if it started ringing but was NOT answered,
    //     // AND EITHER no StasisEnd event has occurred, OR the StasisEnd event happened before the abandonment threshold.

    //     $short_misses_or_ringing = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //         ->where('callers.channel_state', 'Ring')
    //         ->whereBetween('callers.timestamp', [$time_start, $time_end])

    //         // Condition A: Ensure it was NOT answered (No 'Up' event)
    //         ->whereNotExists(function ($query) use ($inbound_trunk_prefix, $stasisStartTable) {
    //             $query->select(DB::raw(1))
    //                   ->from("{$stasisStartTable} AS callees") // Use dynamic table name
    //                   ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]")) = callers.channel_id')
    //                   ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //                   ->where('callees.channel_state', '=', 'Up');
    //         })

    //         // Condition B: Ensure it was NOT truly abandoned (The END event did not exceed the threshold)
    //         ->whereNotExists(function ($query) use ($abandonment_threshold_seconds, $stasisEndTable, $stasisStartTable) {
    //             $query->select(DB::raw(1))
    //                   ->from("{$stasisEndTable} AS ends_short") // Use dynamic table name
    //                   ->whereRaw('ends_short.channel_id = callers.channel_id') // Link to caller's channel
    //                   // Check for existence of an end event that IS an abandonment
    //                   ->whereRaw("TIMESTAMPDIFF(SECOND, callers.timestamp, ends_short.timestamp) >= $abandonment_threshold_seconds");
    //         })
    //         // Note: Calls currently ringing will satisfy both whereNotExists clauses (no 'Up' and no 'ends_short' that is >= 15s)

    //         ->select([
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, NOW()) AS current_ring_duration_seconds"),
    //         ])
    //         ->get();


    //     // --- Preparing Final Analysis for dd() ---

    //     $total_answered = $answered_calls->count();
    //     $total_abandoned = $abandoned_calls->count();
    //     $total_missed_short = $short_misses_or_ringing->count();
    //     $total_calls = $total_answered + $total_abandoned + $total_missed_short; // Total attempts in range

    //     // Answer time metrics
    //     $total_answer_time = $answered_calls->sum('time_to_answer_seconds');
    //     $asa = $total_answered > 0 ? $total_answer_time / $total_answered : 0;

    //     // Talk time metrics (NEW)
    //     $total_talk_time = $answered_calls->sum('talk_time_seconds');
    //     $aht = $total_answered > 0 ? $total_talk_time / $total_answered : 0;

    //     $analysis_summary = [
    //         'Configuration' => [
    //             'Time Range Start' => $time_start,
    //             'Time Range End' => $time_end,
    //             'Inbound Trunk Prefix' => $inbound_trunk_prefix,
    //             'Abandonment Threshold (s)' => $abandonment_threshold_seconds,
    //         ],
    //         'Key Metrics' => [
    //             'Total Call Attempts' => $total_calls,
    //             'Total Answered Calls' => $total_answered,
    //             'Total Abandoned Calls (>= 15s)' => $total_abandoned,
    //             'Total Short Missed/Ringing Calls (< 15s)' => $total_missed_short,
    //             '--- Performance ---' => null,
    //             'Average Speed to Answer (ASA)' => number_format($asa, 2) . ' seconds',
    //             'Average Handle Time (AHT / Avg Talk Time)' => number_format($aht, 2) . ' seconds', // NEW METRIC
    //         ],
    //         // Include the collections for deep inspection
    //         'Detailed Collections' => [
    //             'Answered Calls (w/ Talk Time)' => $answered_calls,
    //             'Abandoned Calls (True)' => $abandoned_calls,
    //             'Short Misses/Ringing' => $short_misses_or_ringing,
    //         ],
    //     ];

    //     // --- Outputting the Final Analysis using dd() ---
    //     dd($analysis_summary);

    //     return view('livewire.live.stasis-start-events-component',[
    //         'stasisEndEventLog' => $stasisEndEventLog,
    //         // 'answered' => $answered,
    //         // 'abandoned' => $abandoned,
    //         // 'missed' => $missed,
    //     ]);
    // }


    // public function render()
    // {
    //     // Get table names dynamically to ensure accuracy and readability
    //     $stasisStartTable = (new StasisStartEvent())->getTable();
    //     $stasisEndTable = (new StasisEndEvent())->getTable();

    //     // --- Configuration ---
    //     $inbound_trunk_prefix = 'PJSIP/alice%';
    //     $time_start = '2025-10-17 10:00:00Z'; // Time range start (for both start/end events)
    //     $time_end = '2025-10-17 14:04:00Z'; // Time range end
    //     $abandonment_threshold_seconds = 15; // Standard 15-second abandonment threshold

    //     // --- 1. ANSWERED CALLS ANALYSIS (Now includes Talk Time using StasisEndEvent) ---
    //     $answered_calls = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         // Join to find the successful callee leg (The 'Up' event)
    //         ->join("{$stasisStartTable} AS callees", function ($join) use ($inbound_trunk_prefix) {
    //             // Link the inbound leg (callers.channel_id) to the callee's 'args' (position 2 in StasisStart args)
    //             $join->on(DB::raw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]"))'), '=', 'callers.channel_id')
    //                 // Callee must be an agent channel, not the trunk
    //                 ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //                 ->where('callees.channel_state', '=', 'Up')
    //                 // Exclude non-SIP media channels (e.g., UnicastRTP)
    //                 ->where('callees.channel_name', 'like', 'PJSIP/%');
    //         })
    //         // NEW: Join to find the Stasis End event for the *answered* leg to calculate talk time
    //         // We use the dynamic table name and simplified join syntax
    //         ->join("{$stasisEndTable} AS ends", 'ends.channel_id', '=', 'callees.channel_id')

    //         // Filter by caller leg criteria
    //         ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //         ->where('callers.channel_state', '=', 'Ring')
    //         ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //         ->select([
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             'callees.timestamp AS answer_time',
    //             'ends.timestamp AS hangup_time', // The end of the call
    //             'callees.caller_name AS agent_name',
    //             DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) AS agent_extension"),
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, callees.timestamp) AS time_to_answer_seconds"),
    //             DB::raw("TIMESTAMPDIFF(SECOND, callees.timestamp, ends.timestamp) AS talk_time_seconds"), // NEW METRIC
    //         ])
    //         ->orderBy('ring_time')
    //         ->get();

    //     // --- 2. IDENTIFY ALL UNANSWERED CALL IDs (The total 110 calls) ---
    //     $unanswered_all_ids = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         ->where('callers.channel_name', 'like', $inbound_trunk_prefix)
    //         ->where('callers.channel_state', 'Ring')
    //         ->whereBetween('callers.timestamp', [$time_start, $time_end])
    //         // Ensure it was NOT answered (No 'Up' event on the related channel)
    //         ->whereNotExists(function ($query) use ($inbound_trunk_prefix, $stasisStartTable) {
    //             $query->select(DB::raw(1))
    //                 ->from("{$stasisStartTable} AS callees")
    //                 ->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(callees.args, "$[2]")) = callers.channel_id')
    //                 ->where('callees.channel_name', 'not like', $inbound_trunk_prefix)
    //                 ->where('callees.channel_state', '=', 'Up');
    //         })
    //         ->pluck('channel_id')
    //         ->toArray();


    //     // --- 3. TRUE ABANDONED CALLS (The 103 calls, subset of unanswered) ---
    //     // This query identifies abandonment (unanswered + duration >= threshold).
    //     $abandoned_calls = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         // Restrict to the set of unanswered IDs found above
    //         ->whereIn('callers.channel_id', $unanswered_all_ids)

    //         // Join to find the Stasis End event on the *caller* channel
    //         ->join("{$stasisEndTable} AS ends", 'ends.channel_id', '=', 'callers.channel_id')

    //         // Only include calls that hung up after the abandonment threshold (business rule)
    //         ->whereRaw("TIMESTAMPDIFF(SECOND, callers.timestamp, ends.timestamp) >= $abandonment_threshold_seconds")
    //         ->select([
    //             'callers.channel_id', // Select channel_id for subtraction in next step
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             'ends.timestamp AS hangup_time',
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, ends.timestamp) AS ring_duration_seconds"),
    //         ])
    //         ->get();

    //     $abandoned_ids = $abandoned_calls->pluck('channel_id')->toArray();


    //     // --- 4. SHORT MISSED CALLS / STILL RINGING (Calculated by Subtraction - Expected 7 calls) ---
    //     // Take ALL unanswered IDs and subtract the TRUE ABANDONED IDs.
    //     $short_missed_ids = array_diff($unanswered_all_ids, $abandoned_ids);

    //     // Fetch the actual models for the short misses
    //     $short_misses_or_ringing = StasisStartEvent::from("{$stasisStartTable} AS callers")
    //         ->whereIn('callers.channel_id', $short_missed_ids)
    //         ->select([
    //             'callers.caller_number',
    //             'callers.timestamp AS ring_time',
    //             // We show current ring time as a proxy for calls that have not yet ended
    //             DB::raw("TIMESTAMPDIFF(SECOND, callers.timestamp, NOW()) AS current_ring_duration_seconds"),
    //         ])
    //         ->get();


    //     // --- Preparing Final Analysis for dd() ---

    //     $total_answered = $answered_calls->count();
    //     $total_abandoned = $abandoned_calls->count(); // Expected 103
    //     $total_missed_short = $short_misses_or_ringing->count(); // Expected 7
    //     $total_calls = $total_answered + $total_abandoned + $total_missed_short; // Total attempts in range (Expected 539)

    //     // Answer time metrics
    //     $total_answer_time = $answered_calls->sum('time_to_answer_seconds');
    //     $asa = $total_answered > 0 ? $total_answer_time / $total_answered : 0;

    //     // Talk time metrics (NEW)
    //     $total_talk_time = $answered_calls->sum('talk_time_seconds');
    //     $aht = $total_answered > 0 ? $total_talk_time / $total_answered : 0;

    //     $analysis_summary = [
    //         'Configuration' => [
    //             'Time Range Start' => $time_start,
    //             'Time Range End' => $time_end,
    //             'Inbound Trunk Prefix' => $inbound_trunk_prefix,
    //             'Abandonment Threshold (s)' => $abandonment_threshold_seconds,
    //         ],
    //         'Key Metrics' => [
    //             'Total Call Attempts' => $total_calls,
    //             'Total Answered Calls' => $total_answered,
    //             // These keys are now guaranteed to reflect the 103 and 7 split:
    //             'Total Abandoned Calls' => $total_abandoned,
    //             'Total Short Missed/Still Ringing Calls' => $total_missed_short,
    //             '--- Performance ---' => null,
    //             'Average Speed to Answer (ASA)' => number_format($asa, 2) . ' seconds',
    //             'Average Handle Time (AHT / Avg Talk Time)' => number_format($aht, 2) . ' seconds', // NEW METRIC
    //         ],
    //         // Include the collections for deep inspection
    //         'Detailed Collections' => [
    //             'Answered Calls (w/ Talk Time)' => $answered_calls,
    //             'Abandoned Calls (True, >= 15s)' => $abandoned_calls,
    //             'Short Misses/Ringing (< 15s or Active)' => $short_misses_or_ringing,
    //         ],
    //     ];

    //     // --- Outputting the Final Analysis using dd() ---
    //     dd($analysis_summary);
    //     $stasisEndEventLog = StasisStartEvent::whereBetween('timestamp', [$time_start, $time_end])
    //         ->take(100);

    //     return view('livewire.live.stasis-start-events-component', [
    //         'stasisEndEventLog' => $stasisEndEventLog,
    //         'answered' => $total_answered,
    //         'abandoned' => $total_abandoned,
    //         'missed' => $total_missed_short,
    //     ]);
    // }
    public $metrics = [];
    public function render(){
        // This is the FAST query, representative of how the Livewire component should run.
        $metricsResult = StasisCDR::query()
            ->select(
                DB::raw('SUM(is_answered) as answered_calls'),
                DB::raw('SUM(is_abandoned) as abandoned_calls'),
                DB::raw('SUM(is_short_miss) as short_missed_calls'),
                DB::raw('COUNT(*) as total_attempts'),
                // Include the total time to answer for ASA calculation
                DB::raw('SUM(time_to_answer_seconds) as total_answer_time')
            )
            ->first();

        // --- Calculate ASA ---
        $totalAnswered = $metricsResult->answered_calls ?? 0;
        $totalAnswerTime = $metricsResult->total_answer_time ?? 0;

        // ASA = Total Answer Time / Total Answered Calls
        $asa = $totalAnswered > 0 ? $totalAnswerTime / $totalAnswered : 0;

        // Structure the metrics for the view
        $this->metrics = [
            'answered' => $totalAnswered,
            'abandoned' => $metricsResult->abandoned_calls ?? 0,
            'missed' => $metricsResult->short_missed_calls ?? 0,
            'total' => $metricsResult->total_attempts ?? 0,
            'asa' => number_format($asa, 2) . ' seconds', // Average Speed to Answer
        ];

        dd($this->metrics);

        return view('livewire.live.stasis-start-events-component', [
            'answered' => $totalAnswered,
            'abandoned' => $metricsResult->abandoned_calls ?? 0,
            'missed' => $metricsResult->short_missed_calls ?? 0,
            'total' => $metricsResult->total_attempts ?? 0,
            'asa' => number_format($asa, 2) . ' seconds', // Average Speed to Answer
        ]);
    }
}


// <?php

// namespace App\Http\Livewire\Live;

// use App\Models\Live\StasisStartEvent;
// use Carbon\Carbon;
// use Livewire\Component;
// use Illuminate\Support\Facades\DB;

// class StasisStartEventComponent extends Component
// {
//     public function render()
//     {
//         //     $answered = StasisStartEvent::from('stasis_start_events as callers')
//         // ->join('stasis_start_events as callees', function ($join) {
//         //     $join->on('callers.caller_number', '=', 'callees.caller_number')
//         //          ->where('callees.channel_name', 'like', 'PJSIP/%')
//         //          ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//         //          ->where('callees.channel_state', '=', 'Up');
//         // })
//         // ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//         // ->where('callers.channel_state', '=', 'Ring')
//         // ->select([
//         //     'callers.caller_number',
//         //     'callers.timestamp as call_time',
//         //     DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) as callee_extension"),
//         //     'callers.channel_name as caller_channel',
//         //     'callees.channel_name as callee_channel',
//         // ])
//         // ->get();

//         // $missed = StasisStartEvent::from('stasis_start_events as callers')
//         // ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//         // ->where('callers.channel_state', 'Ring')
//         // ->whereNotExists(function ($query) {
//         //     $query->select(DB::raw(1))
//         //           ->from('stasis_start_events as callees')
//         //           ->whereRaw('callees.caller_number = callers.caller_number')
//         //           ->where('callees.channel_name', 'like', 'PJSIP/%')
//         //           ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//         //           ->where('callees.channel_state', '=', 'Up');
//         // })
//         // ->select([
//         //     'callers.caller_number',
//         //     'callers.timestamp as call_time',
//         //     DB::raw("SUBSTRING_INDEX(callers.channel_name, '-', 1) as caller_channel"),
//         // ])
//         // ->get();

//         // $abandoned = StasisStartEvent::from('stasis_start_events as callers')
//         // ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//         // ->where('callers.channel_state', '=', 'Ring')
//         // ->whereNotExists(function ($query) {
//         //     $query->select(DB::raw(1))
//         //           ->from('stasis_start_events as callees')
//         //           ->whereRaw('callers.caller_number = callees.caller_number')
//         //           ->where('callees.channel_name', 'like', 'PJSIP/%')
//         //           ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//         //           ->where('callees.channel_state', '=', 'Up');
//         // })
//         // ->where('callers.timestamp', '<', now()->subSeconds(15)) // abandonment threshold
//         // ->select([
//         //     'callers.caller_number',
//         //     'callers.timestamp as call_time',
//         //     'callers.channel_name as caller_channel'
//         // ])
//         // ->get();

//         // dd($answeredCalls, $abandonedCalls, $missedCalls);
//         // --- Define the Date Range ---
//         // Set the start date/time: October 17, 2025, 10:00:00
//         // --- Define the Date Range (October 17, 2025, 10:00 to 14:00) ---

//         // --- Define the Date Range (October 17, 2025, 10:00 to 14:00) ---
//         $startDate = Carbon::create(2025, 10, 17, 10, 0, 0);
//         $endDate = Carbon::create(2025, 10, 17, 14, 0, 0);

//         // Define a consistent time limit for the abandonment check
//         // We use the $endDate of the report minus the threshold (15 seconds).
//         $abandonmentLimit = $endDate->copy()->subSeconds(15);


//         // --- Answered Calls Query (returns Collection) ---
//         $answeredCalls = StasisStartEvent::from('stasis_start_events as callers')
//             // FIX 1: Use 'callers.timestamp' for accurate time filtering
//             ->whereBetween('callers.timestamp', [$startDate, $endDate])
//             ->join('stasis_start_events as callees', function ($join) {
//                 $join->on('callers.caller_number', '=', 'callees.caller_number')
//                     ->where('callees.channel_name', 'like', 'PJSIP/%')
//                     ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//                     ->where('callees.channel_state', '=', 'Up');
//             })
//             ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//             ->where('callers.channel_state', '=', 'Ring')
//             ->select([
//                 'callers.caller_number',
//                 'callers.timestamp as call_time',
//                 DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) as callee_extension"),
//                 'callers.channel_name as caller_channel',
//                 'callees.channel_name as callee_channel',
//             ])
//             ->get(); // <-- Returns the collection of records

//         // --- Missed Calls Query (returns Collection) ---
//         $missedCalls = StasisStartEvent::from('stasis_start_events as callers')
//             // FIX 1: Use 'callers.timestamp' for accurate time filtering
//             ->whereBetween('callers.timestamp', [$startDate, $endDate])
//             ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//             ->where('callers.channel_state', 'Ring')
//             ->whereNotExists(function ($query) {
//                 $query->select(DB::raw(1))
//                     ->from('stasis_start_events as callees')
//                     ->whereRaw('callees.caller_number = callers.caller_number')
//                     ->where('callees.channel_name', 'like', 'PJSIP/%')
//                     ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//                     ->where('callees.channel_state', '=', 'Up');
//             })
//             ->select([
//                 'callers.caller_number',
//                 'callers.timestamp as call_time',
//                 DB::raw("SUBSTRING_INDEX(callers.channel_name, '-', 1) as caller_channel"),
//             ])
//             ->get(); // <-- Returns the collection of records

//         // --- Abandoned Calls Query (returns Collection) ---
//         $abandonedCalls = StasisStartEvent::from('stasis_start_events as callers')
//             // FIX 1: Use 'callers.timestamp' for accurate time filtering
//             ->whereBetween('callers.timestamp', [$startDate, $endDate])
//             ->where('callers.channel_name', 'like', 'PJSIP/mytrank%')
//             ->where('callers.channel_state', '=', 'Ring')
//             ->whereNotExists(function ($query) {
//                 $query->select(DB::raw(1))
//                     ->from('stasis_start_events as callees')
//                     ->whereRaw('callers.caller_number = callees.caller_number')
//                     ->where('callees.channel_name', 'like', 'PJSIP/%')
//                     ->where('callees.channel_name', 'not like', 'PJSIP/mytrank%')
//                     ->where('callees.channel_state', '=', 'Up');
//             })
//             // FIX 2: Compare against the fixed $abandonmentLimit
//             ->where('callers.timestamp', '<', $abandonmentLimit)
//             ->select([
//                 'callers.caller_number',
//                 'callers.timestamp as call_time',
//                 'callers.channel_name as caller_channel'
//             ])
//             ->get(); // <-- Returns the collection of records

//         // --- Pagination Query for the detailed log table ---
//         $stasisEndEventLog = StasisStartEvent::whereBetween('timestamp', [$startDate, $endDate])
//             ->paginate(10);

//             dd($stasisEndEventLog);

//         // --- Pass ALL data (Collections and Counts) to the view ---
//         return view('livewire.live.stasis-start-events-component', [
//             // Counts for the stats table
//             'answered' => $answeredCalls->count(),
//             'missed' => $missedCalls->count(),
//             'abandoned' => $abandonedCalls->count(),

//             // Collections for the detailed call list
//             'answeredCalls' => $answeredCalls,
//             'missedCalls' => $missedCalls,
//             'abandonedCalls' => $abandonedCalls,

//             // Paginated log data
//             'stasisEndEventLog' => $stasisEndEventLog,
//         ]);
//     }
// }

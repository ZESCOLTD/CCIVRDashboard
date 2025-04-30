<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisStartEvent;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class StasisStartEventsComponent extends Component
{
    public function render()
    {
        $answered = StasisStartEvent::from('stasis_start_events as callers')
    ->join('stasis_start_events as callees', function ($join) {
        $join->on('callers.caller_number', '=', 'callees.caller_number')
             ->where('callees.channel_name', 'like', 'PJSIP/%')
             ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
             ->where('callees.channel_state', '=', 'Up');
    })
    ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    ->where('callers.channel_state', '=', 'Ring')
    ->select([
        'callers.caller_number',
        'callers.timestamp as call_time',
        DB::raw("SUBSTRING_INDEX(callees.channel_name, '-', 1) as callee_extension"),
        'callers.channel_name as caller_channel',
        'callees.channel_name as callee_channel',
    ])
    ->get();

    $missed = StasisStartEvent::from('stasis_start_events as callers')
    ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    ->where('callers.channel_state', 'Ring')
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('stasis_start_events as callees')
              ->whereRaw('callees.caller_number = callers.caller_number')
              ->where('callees.channel_name', 'like', 'PJSIP/%')
              ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
              ->where('callees.channel_state', '=', 'Up');
    })
    ->select([
        'callers.caller_number',
        'callers.timestamp as call_time',
        DB::raw("SUBSTRING_INDEX(callers.channel_name, '-', 1) as caller_channel"),
    ])
    ->get();

    $abandoned = StasisStartEvent::from('stasis_start_events as callers')
    ->where('callers.channel_name', 'like', 'PJSIP/mytrunk%')
    ->where('callers.channel_state', '=', 'Ring')
    ->whereNotExists(function ($query) {
        $query->select(DB::raw(1))
              ->from('stasis_start_events as callees')
              ->whereRaw('callers.caller_number = callees.caller_number')
              ->where('callees.channel_name', 'like', 'PJSIP/%')
              ->where('callees.channel_name', 'not like', 'PJSIP/mytrunk%')
              ->where('callees.channel_state', '=', 'Up');
    })
    ->where('callers.timestamp', '<', now()->subSeconds(15)) // abandonment threshold
    ->select([
        'callers.caller_number',
        'callers.timestamp as call_time',
        'callers.channel_name as caller_channel'
    ])
    ->get();

    // dd($answeredCalls, $abandonedCalls, $missedCalls);

        $stasisEndEventLog = StasisStartEvent::paginate(10);

        return view('livewire.live.stasis-start-events-component',[
            'stasisEndEventLog' => $stasisEndEventLog,
            'answered' => $answered,
            'abandoned' => $abandoned,
            'missed' => $missed,
        ]);
    }
}

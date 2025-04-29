<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\DialEventLog;
use Livewire\Component;

class DialEventsComponent extends Component
{
    public function render()
    {
        // $missedCallIds = DialEventLog::missed()->pluck('dialstring');
        //         $answered = DialEventLog::missed()->get();

        //         dd($answered);

        // $missedCalls = DialEventLog::whereIn('dialstring', $missedCallIds)
        //     ->orderBy('event_timestamp', 'desc')
        //     ->get();

        $calls = DialEventLog::orderBy('event_timestamp')
            ->get()
            ->groupBy(function ($event) {
                return $event->dialstring . '_' . $event->peer_id;
            });


        $callResults = $calls->map(function ($events, $key) {
            $sorted = $events->sortBy('event_timestamp');

            $lastWithStatus = $sorted->reverse()->first(fn($e) => !empty($e->dialstatus));

            if (!$lastWithStatus) return null;

            return [
                'dialstring' => $lastWithStatus->dialstring,
                'caller_number' => $lastWithStatus->caller_number,
                'status' => $lastWithStatus->dialstatus,
                'timestamp' => $lastWithStatus->event_timestamp,
            ];
        })->filter(); // remove nulls


        // dd($callResults);

        $answered = $callResults->where('status', 'ANSWER');
        $missed = $callResults->where('status', 'NOANSWER');

        // dd($answered);

        $dialEventLog = DialEventLog::paginate(10);

        return view('livewire.live.dial-events-component', [
            'dialEventLog' => $dialEventLog,
            'answered' => $answered,
            'missed' => $missed,
        ]);
    }

    // public function scopeAnswered($query)
    // {
    //     return $query->where('dialstatus', 'ANSWER')
    //         ->where('peer_state', 'Up')
    //         ->whereNotNull('peer_name')
    //         ->orderBy('event_timestamp', 'desc');
    // }

    // public function scopeMissed($query)
    // {
    //     // Get asterisk_ids where a RINGING event exists but no corresponding ANSWER
    //     return $query->select('asterisk_id')
    //         ->where('dialstatus', 'RINGING')
    //         ->whereNotNull('asterisk_id')
    //         ->whereNotExists(function ($subquery) {
    //             $subquery->selectRaw(1)
    //                 ->from('dial_event_logs as del2')
    //                 ->whereColumn('del2.asterisk_id', 'dial_event_logs.asterisk_id')
    //                 ->where('del2.dialstatus', 'ANSWER');
    //         })
    //         ->groupBy('asterisk_id');
    // }
}

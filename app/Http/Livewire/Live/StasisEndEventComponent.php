<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisEndEvent;
use Livewire\Component;

class StasisEndEventComponent extends Component
{
    public function render()
    {

        // Fetch all StasisEndEvent records grouped by the caller's channel_id
        $groupedCalls = StasisEndEvent::groupByCallerChannel();

        $abandonedCalls = [];
        $missedCalls = [];
        $answeredCalls = [];

        foreach ($groupedCalls as $callPair) {
            $caller = $callPair['caller'];
            $callee = $callPair['callee'];

            // Classify abandoned, missed, and answered calls
            if ($callee->isAbandoned()) {
                $abandonedCalls[] = [
                    'caller' => $caller,
                    'callee' => $callee,
                ];
            } elseif ($callee->isMissed()) {
                $missedCalls[] = [
                    'caller' => $caller,
                    'callee' => $callee,
                ];
            } elseif ($callee->isAnswered()) {
                $answeredCalls[] = [
                    'caller' => $caller,
                    'callee' => $callee,
                ];
            }
        }

        // dd($abandonedCalls, $missedCalls, $answeredCalls);

        $stasisEndEventLog = StasisEndEvent::paginate(10);
        return view('livewire.live.stasis-end-events-component', [
            'stasisEndEventLog' => $stasisEndEventLog,
        ]);
    }
}

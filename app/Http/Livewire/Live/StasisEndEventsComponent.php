<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisEndEvent;
use Livewire\Component;

class StasisEndEventsComponent extends Component
{
    public function render()
    {

        $stasisEndEventLog = StasisEndEvent::paginate(10);
        return view('livewire.live.stasis-end-events-component', [
            'stasisEndEventLog' => $stasisEndEventLog,
        ]);
    }
}

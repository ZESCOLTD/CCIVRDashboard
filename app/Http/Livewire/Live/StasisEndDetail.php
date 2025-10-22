<?php

namespace App\Http\Livewire\Live;

use Livewire\Component;
use App\Models\Live\StasisEndEvent; // Adjust model path if necessary

class StasisEndDetail extends Component
{
    public $event;

    /**
     * @param int $id The ID of the StasisEndEvent record.
     */
    public function mount($id)
    {
        $this->event = StasisEndEvent::findOrFail($id);
    }

    public function render()
    {
        // This will look for the view resources/views/live/stasis-end-detail.blade.php
        return view('live.stasis-end-detail');
    }
}
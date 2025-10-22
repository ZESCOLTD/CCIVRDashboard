<?php

namespace App\Http\Livewire\Live;

use Livewire\Component;
use App\Models\Live\StasisStartEvent; // Adjust model path if necessary

class StasisStartDetail extends Component
{
    public $event;

    /**
     * @param int $id The ID of the StasisStartEvent record.
     */
    public function mount($id)
    {
        // Fetch the raw event record. If the JSON data is stored in a column like 'raw_data',
        // you might only need to display the array/object representation.
        $this->event = StasisStartEvent::findOrFail($id);
    }

    public function render()
    {
        // This will look for the view resources/views/live/stasis-start-detail.blade.php
        return view('live.stasis-start-detail');
    }
}
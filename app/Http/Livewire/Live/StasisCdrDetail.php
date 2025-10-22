<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisCDR;
use Livewire\Component;

class StasisCdrDetail extends Component
{
    /**
     * @var StasisCDR The StasisCDR model instance for the detail view.
     */
    public $cdr;

    /**
     * Mount the component, fetching the specific StasisCDR record.
     *
     * @param int $id The ID of the StasisCDR record.
     */
    public function mount($id)
    {
        // Find the StasisCDR record, eagerly loading the related raw events
        // (StasisStart and StasisEnd) for auditing links in the view.
        $this->cdr = StasisCDR::with(['stasisStart', 'stasisEnd'])->findOrFail($id);
    }

    /**
     * Render the Livewire component view.
     */
    public function render()
    {
        return view('live.cdr-details');
    }
}
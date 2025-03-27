<?php

namespace App\Http\Livewire\Session;

use App\Models\Live\CallSession;
use Livewire\Component;

class ShowCallSession extends Component
{
    protected $listeners = [
        'deleteCallSession' => 'remove'
    ];

    public $name;
    public $description;
    public $time_from;
    public $time_to;

    public $selectedSession;
    public function mount($id)
    {
        $this->selectedSession = CallSession::find($id);

        $this->name = $this->selectedSession->name;
        $this->description = $this->selectedSession->description;
        $this->time_from = $this->selectedSession->time_from;
        $this->time_to = $this->selectedSession->time_to;
    }

    public function render()
    {
        return view('livewire.session.show-call-session', ['session' => $this->selectedSession]);
    }

    public function remove()
    {
        CallSession::where('id', $this->selectedSession->id)->delete();
        session()->flash('success', 'Call session deleted successfully!');
        return redirect()->route('session.call-sessions')->with('success', 'Call session deleted successfully!');
    }

    public function edit()
    {

        $this->selectedSession->name = $this->name;
        $this->selectedSession->description = $this->description;
        $this->selectedSession->time_from = $this->time_from;
        $this->selectedSession->time_to = $this->time_to;
        $this->selectedSession->save();


        // Flash success message
        session()->flash('success', 'Session updated successfully!');

        // Emit event to close the modal
        $this->emit('closeModal');
    }
}

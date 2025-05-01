<?php

namespace App\Http\Livewire\Live;

use Livewire\Component;
use App\Models\Live\CallSession;
use App\Models\User;

class AgentComponent extends Component
{

    public ?string $selectedSession = null;

    public function mount($id)
    {
        $this->agent = User::findOrFail($id);
        $this->user = $this->agent;

        $this->sessions = CallSession::all();
        $this->selectedSession = session('current_session_id', '');

        // Check if the agent is already on break
        if ($this->agent && $this->agent->status === config('constants.agent_status.ON_BREAK')) {
            $this->onBreak = true;
            $this->breakStartTime = $this->agent->updated_at;

            // Calculate the initial duration on load
            dd($seconds = now()->diffInSeconds($this->breakStartTime));
            $this->breakDuration = gmdate('H:i:s', $seconds);

            $this->checkBreakLimit($seconds);
        }
    }


    public function saveSession()
    {
        // Dummy logic
        session()->flash('message', 'Session saved!');
        $this->emit('closeSessionModal');
    }

    public function render()
    {
        $sessions = [
            (object)['id' => '1', 'name' => 'Session A'],
            (object)['id' => '2', 'name' => 'Session B'],
        ];

        return view('livewire.live.agent-component',compact('sessions'));
    }
}

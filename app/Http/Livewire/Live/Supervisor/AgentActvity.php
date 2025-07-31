<?php

namespace App\Http\Livewire\Live\Supervisor;
use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Auth;  // Correct Auth import
use App\Models\Live\CCAgent;

use Livewire\Component;

class AgentActvity extends Component
{
    public function render()
    {

        $api_server = config("app.API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");
        $sessions = CallSession::all();

        $availableAgents = CCAgent::where(function ($query) {
            $query->whereIn('state', ['AgentState.LOGGEDIN','LOGGED_IN'])
                ;
        })->get();

        $totalAgentCount = CCAgent::count();
        return view('livewire.live.supervisor.agent-actvity',[
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'sessions' => $sessions,
            'user' => Auth::user(), // Add authenticated user data
            'availableAgents' => $availableAgents,
            'totalAgentCount' => $totalAgentCount,
        ]);
    }
}

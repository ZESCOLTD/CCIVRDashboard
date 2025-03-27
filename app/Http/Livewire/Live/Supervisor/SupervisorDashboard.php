<?php

namespace App\Http\Livewire\Live\Supervisor;

use App\Models\Live\CallSession;
use Livewire\Component;

class SupervisorDashboard extends Component
{
    public function render()
    {
        $api_server = config("app.API_SERVER_ENDPOINT");
        // env("API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");

        $sessions = CallSession::all();
        //$ws_server = env("WS_SERVER_ENDPOINT");
        //dd([$api_server, $ws_server]);
        return view('livewire.live.supervisor.supervisor-dashboard', ['api_server' => $api_server, 'ws_server' => $ws_server, 'sessions' => $sessions]);
    }
}

<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\CCAgent;
use Livewire\Component;

class DashboardController extends Component
{
    public function render()
    {

        $activeAgents = CCAgent::where('state', '==', 'AgentState.LOGGED_IN')
            ->orWhere('state', '==', 'LOGGED_IN')
            ->get();
        return view('livewire.live.dashboard-controller',[
            'activeAgents' => $activeAgents,
        ]);
    }
}

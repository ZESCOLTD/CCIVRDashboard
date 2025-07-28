<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Livewire\Component;

class NetworkPieChart extends Component
{
    public $sessions;

    public function render()
    {

        $sessions = UssdSession::selectRaw('network, COUNT(network) as count')
            ->whereDate('created_at', now())
            ->groupBy('NETWORK')
            ->orderBy('network', 'ASC')->get();

        $labels = $sessions->pluck('network')->all();
        $data = $sessions->pluck('count')->all();
        $total = $sessions->pluck('count')->sum();
        return view('livewire.dashboard.network-pie-chart', compact('labels', 'data','total'));
    }
}

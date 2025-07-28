<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Livewire\Component;

class TopMenuSelectedChart extends Component
{
    public function render()
    {
        $sessions = UssdSession::selectRaw('menu, COUNT(network) as count')
            ->whereDate('created_at', now())
            ->groupBy(['MENU',])
            ->orderBy('count', 'DESC')
            ->get();
        return view('livewire.dashboard.top-menu-selected-chart', compact('sessions'));
    }
}

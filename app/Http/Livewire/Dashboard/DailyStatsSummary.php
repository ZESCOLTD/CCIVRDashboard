<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Livewire\Component;

class DailyStatsSummary extends Component
{
    public function render()
    {
        $dailyStats = UssdSession::selectRaw('network, COUNT(*) as sessions')
            ->whereDate('created_at', now()->subDays(1))
            ->groupBy(['NETWORK',])
            ->orderBy('sessions', 'DESC')
            ->get();
        return view('livewire.dashboard.daily-stats-summary', compact('dailyStats'));
    }
}

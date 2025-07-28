<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\UssdSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class DailyStatsSummary extends Component
{
    public function render()
    {
        // Define time periods
        $now = now();
        $currentStart = $now->copy()->subDay();
        $previousStart = $now->copy()->subDays(2);
        $previousEnd = $now->copy()->subDay();
        $yesterday = Carbon::yesterday();
        $dayBeforeYesterday = Carbon::yesterday()->subDay(); // For yesterday's comparison

         // Define reusable variables
         $dstExtensions = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'];

        // Get current period stats
        $currentPeriod = UssdSession::selectRaw('network, COUNT(*) as sessions')
        ->whereDate('created_at', now()->subDays(2))
            ->groupBy('network')
            ->get()
            ->keyBy('network');

        // Get previous period stats
        $previousPeriod = UssdSession::selectRaw('network, COUNT(*) as sessions')
        ->whereDate('created_at', now()->subDays(1))
            ->groupBy('network')
            ->get()
            ->keyBy('network');

             // Merge data for the frontend
        $merged = $currentPeriod->map(function ($current, $network) use ($previousPeriod) {
            $previous = $previousPeriod[$network] ?? (object)['sessions' => 0];

            $change = $current->sessions > 0
                ? (($previous->sessions - $current->sessions) / $current->sessions) * 100
                : ($previous->sessions > 0 ? 100 : 0);

            return (object)[
                'network' => $network,
                'previous' => $previous->sessions,
                'sessions' => $current->sessions,
                'change' => $change,
            ];
        });

              // Total Calls Yesterday
        $ivr_total_calls_yesterday = CallDetailsRecordModel::whereDate('calldate', $yesterday)
        ->whereIn('dst', $dstExtensions)
        ->count();

    // Total Calls Day Before Yesterday (for comparison with yesterday's calls)
    $ivr_total_calls_day_before_yesterday = CallDetailsRecordModel::whereDate('calldate', $dayBeforeYesterday)
        ->whereIn('dst', $dstExtensions)
        ->count();
        $ivr_change = $ivr_total_calls_yesterday > 0
            ? (($ivr_total_calls_day_before_yesterday - $ivr_total_calls_yesterday) / $ivr_total_calls_yesterday) * 100
            : ($ivr_total_calls_day_before_yesterday > 0 ? 100 : 0);
        $ivr_previousPeriod = (object)[
            'network' => 'IVR',
            'previous' => $ivr_total_calls_yesterday,
            'sessions' => $ivr_total_calls_day_before_yesterday,
            'change' => $ivr_change,
        ];


        // Add IVR stats
// $merged->push($ivr_previousPeriod);


        return view('livewire.dashboard.daily-stats-summary', [
            'dailyStats' => $merged->values(), // Re-index numerically
        ]);
    }
}

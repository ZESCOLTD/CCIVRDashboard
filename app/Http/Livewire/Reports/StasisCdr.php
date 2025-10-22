<?php

namespace App\Http\Livewire\Reports;

use App\Models\Live\StasisCDR;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CallReport extends Component
{
    // Default time range can be set here or configured via inputs
    public $startDate;
    public $endDate;
    public $metrics;
    public $callRecords;

    public function mount()
    {
        // Set default filter to the last 24 hours or the time range of your seeder
        $this->endDate = now()->endOfDay()->format('Y-m-d H:i');
        $this->startDate = now()->subDays(1)->startOfDay()->format('Y-m-d H:i');
        $this->loadData();
    }

    public function loadData()
    {
        $query = StasisCDR::query()
            ->whereBetween('start_time', [$this->startDate, $this->endDate]);

        // --- 1. Aggregated Metrics ---
        $this->metrics = (clone $query)->select(
            DB::raw('COUNT(*) as total_attempts'),
            DB::raw('SUM(is_answered) as answered_calls'),
            DB::raw('SUM(is_abandoned) as abandoned_calls'),
            DB::raw('SUM(is_short_miss) as short_missed_calls'),
            DB::raw('IFNULL(ROUND(AVG(time_to_answer_seconds)), 0) as avg_time_to_answer'),
            DB::raw('IFNULL(ROUND(AVG(talk_time_seconds)), 0) as avg_talk_time')
        )->first();

        // --- 2. Detailed Call List (for the table) ---
        $this->callRecords = (clone $query)
            ->with(['stasisStart', 'stasisEnd']) // Eager load relationships
            ->latest('start_time')
            ->limit(25) // Limit for performance on the dashboard view
            ->get();
    }

    // Function to calculate a key performance indicator (KPI)
    public function getServiceLevelAttribute()
    {
        // Service Level: Answered calls / (Answered + Abandoned)
        $answered = $this->metrics->answered_calls ?? 0;
        $abandoned = $this->metrics->abandoned_calls ?? 0;
        $totalHandled = $answered + $abandoned;

        return $totalHandled > 0
            ? number_format(($answered / $totalHandled) * 100, 1) . '%'
            : 'N/A';
    }

    public function render()
    {
        return view('livewire.reports.stasis-cdr');
    }
}
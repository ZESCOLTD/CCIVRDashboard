<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisCDR;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination; // 1. Import the trait

class CallReport extends Component
{
    use WithPagination; // 2. Use the trait

    // Define public properties for binding to the view filters
    public $startDate;
    public $endDate;
    public $metrics;

    // NOTE: $callRecords property is removed, as paginated data is fetched in render()

    // 3. Optional: Set default pagination theme (Bootstrap 4)
    protected $paginationTheme = 'bootstrap';

    /**
     * Set initial state and load data.
     */
    public function mount()
    {
        // Set default filter to the last 24 hours
        $this->endDate = now()->endOfDay()->format('Y-m-d H:i');
        $this->startDate = now()->subDays(1)->startOfDay()->format('Y-m-d H:i');

        // Calculate metrics initially
        $this->calculateMetrics();
    }

    /**
     * Calculates the aggregate metrics and stores them in $this->metrics.
     */
    public function calculateMetrics()
    {
        // 1. Base Query with Time Filter
        $query = StasisCDR::query()
            ->whereBetween('start_time', [$this->startDate, $this->endDate]);

        // 2. Aggregated Metrics Query
        $this->metrics = (clone $query)->select(
            DB::raw('COUNT(*) as total_attempts'),
            DB::raw('SUM(is_answered) as answered_calls'),
            DB::raw('SUM(is_abandoned) as abandoned_calls'),
            DB::raw('SUM(is_short_miss) as short_missed_calls'),
            DB::raw('IFNULL(ROUND(AVG(time_to_answer_seconds)), 0) as avg_time_to_answer'),
            DB::raw('IFNULL(ROUND(AVG(talk_time_seconds)), 0) as avg_talk_time')
        )->first();
    }

    /**
     * Called when filters change to refresh metrics and reset pagination.
     */
    public function applyFilter()
    {
        $this->resetPage(); // Reset pagination when filters change
        $this->calculateMetrics();
    }

    /**
     * Accessor to calculate the Service Level Percentage.
     */
    public function getServiceLevelProperty()
    {
        $answered = $this->metrics->answered_calls ?? 0;
        $abandoned = $this->metrics->abandoned_calls ?? 0;
        $totalHandled = $answered + $abandoned;

        return $totalHandled > 0
            ? number_format(($answered / $totalHandled) * 100, 1) . '%'
            : 'N/A';
    }

    /**
     * Render the Livewire component view and fetch paginated data.
     */
    public function render()
    {
        // 4. Query the call records for the current page
        $callRecords = StasisCDR::query()
            ->whereBetween('start_time', [$this->startDate, $this->endDate])
            ->with(['stasisStart', 'stasisEnd'])
            ->latest('start_time')
            ->paginate(20); // Paginate the results (e.g., 20 per page)

        return view('live.call-report', [
            'callRecords' => $callRecords,
        ]);
    }
}
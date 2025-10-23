<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\StasisCDR;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CallReport extends Component
{
    use WithPagination;

    // Existing Properties
    public $startDate;
    public $endDate;
    public $metrics;

    // NEW DYNAMIC FILTER PROPERTIES
    public $filterCallerNumber = '';
    public $filterAgentExtension = '';
    public $filterStatus = '';

    // NEW DURATION FILTER PROPERTIES
    public $filterMinRingDuration = null; // Minimum Ring Duration (seconds)
    public $filterMaxRingDuration = null; // Maximum Ring Duration (seconds)
    public $filterMinTalkTime = null;    // Minimum Talk Time (seconds)
    public $filterMaxTalkTime = null;    // Maximum Talk Time (seconds)

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->endDate = now()->endOfDay()->format('Y-m-d H:i');
        $this->startDate = now()->subDays(1)->startOfDay()->format('Y-m-d H:i');
        $this->calculateMetrics();
    }

    /**
     * Calculates the aggregate metrics based on ALL active filters.
     */
    public function calculateMetrics()
    {
        $query = $this->buildBaseQuery();

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
     * Helper to build the base query, applying all dynamic filters.
     */
    protected function buildBaseQuery()
    {
        $query = StasisCDR::query()
            ->whereBetween('start_time', [$this->startDate, $this->endDate]);

        // Apply Text Filters
        if ($this->filterCallerNumber) {
            $query->where('caller_number', 'like', '%' . $this->filterCallerNumber . '%');
        }
        if ($this->filterAgentExtension) {
            $query->where('agent_extension', 'like', '%' . $this->filterAgentExtension . '%');
        }

        // Apply Status filter
        if ($this->filterStatus) {
            switch ($this->filterStatus) {
                case 'answered':
                    $query->where('is_answered', true);
                    break;
                case 'abandoned':
                    $query->where('is_abandoned', true);
                    break;
                case 'short_miss':
                    $query->where('is_short_miss', true);
                    break;
            }
        }

        // APPLY RING DURATION FILTERS
        if (is_numeric($this->filterMinRingDuration)) {
            $query->where('ring_duration_seconds', '>=', $this->filterMinRingDuration);
        }
        if (is_numeric($this->filterMaxRingDuration)) {
            $query->where('ring_duration_seconds', '<=', $this->filterMaxRingDuration);
        }

        // APPLY TALK TIME FILTERS
        if (is_numeric($this->filterMinTalkTime)) {
            // Note: Talk time only applies to answered calls (is_answered = 1)
            $query->where('talk_time_seconds', '>=', $this->filterMinTalkTime);
        }
        if (is_numeric($this->filterMaxTalkTime)) {
            $query->where('talk_time_seconds', '<=', $this->filterMaxTalkTime);
        }


        return $query;
    }

    public function applyFilter()
    {
        $this->resetPage();
        $this->calculateMetrics();
    }

    // Accessor for Service Level remains the same
    public function getServiceLevelProperty()
    {
        $answered = $this->metrics->answered_calls ?? 0;
        $abandoned = $this->metrics->abandoned_calls ?? 0;
        $totalHandled = $answered + $abandoned;

        return $totalHandled > 0
            ? number_format(($answered / $totalHandled) * 100, 1) . '%'
            : 'N/A';
    }

    public function render()
    {
        $callRecords = $this->buildBaseQuery()
            ->with(['stasisStart', 'stasisEnd'])
            ->latest('start_time')
            ->paginate(20);

        return view('live.call-report', [
            'callRecords' => $callRecords,
        ]);
    }
}
<?php

namespace App\Http\Livewire\Reports;

use App\Models\CDR\CallDetailsRecordModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CallSummaryRecords extends Component
{
    public $from, $to, $updated = 'false';
    public $perPage = 10, $search = '', $orderBy = 'id', $orderAsc = true;

    public function render()
    {
        // 1. Establish Date Range (Prevents repeated logic)
        if ($this->from && $this->to) {
            $start = Carbon::parse($this->from)->startOfDay();
            $end = Carbon::parse($this->to)->endOfDay();
        } else {
            $start = Carbon::today()->startOfDay();
            $end = Carbon::today()->endOfDay();
        }

        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();

        // 2. Define Filter Arrays (Makes code readable)
        $dstFilters = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17', 'cc-21'];
        $fieldOrder = "'" . implode("','", $dstFilters) . "','s','#','t'";

        // 3. Query: Summary Today (Uses Index)
        $summary_calls_today = CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$start, $end])
            ->whereIn('dst', $dstFilters)
            ->groupBy('dst')
            ->orderByRaw("FIELD(dst, $fieldOrder) ASC")
            ->get();

        // 4. Query: Speak to Agent (Uses Index)
        $speakToAnAgentCalls = CallDetailsRecordModel::select('disposition', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$start, $end])
            ->where('dst', 'cc-16')
            ->groupBy('disposition')
            ->orderBy('y', $this->orderAsc ? 'asc' : 'desc')
            ->get();

        // 5. Query: Customers (Crucial: Added limit to save memory)
        $summary_calls_customers = CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereBetween('calldate', [$start, $end])
            ->whereIn('dst', $dstFilters)
            ->groupBy('src')
            ->orderBy('total', 'desc')
            ->take(100) // Adjust this limit as needed for your UI
            ->get();

        // 6. Query: Yesterday (Uses Index)
        $total_calls_yesterday = CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$yesterdayStart, $yesterdayEnd])
            ->whereIn('dst', $dstFilters)
            ->groupBy('dst')
            ->get();

        $callsToday = $summary_calls_today->sum('y');

        $this->emit('dataUpdate', [
            'summary_calls_today' => $summary_calls_today,
            'summary_calls_customers' => $summary_calls_customers,
            'callsToday' => $callsToday,
        ]);

        return view('livewire.reports.call-summary-records', compact(
            'summary_calls_today',
            'total_calls_yesterday',
            'summary_calls_customers',
            'callsToday',
            'speakToAnAgentCalls'
        ));
    }

    public function search() {}
}

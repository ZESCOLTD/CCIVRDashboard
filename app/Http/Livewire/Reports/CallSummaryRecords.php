<?php

namespace App\Http\Livewire\Reports;

use App\Models\CDR\CallDetailsRecordModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CallSummaryRecords extends Component
{
    public $from;
    public $to;
    public $updated = 'false';

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public function render()
    {
        $fromDatetime = null;
        $toDatetime = null;

        if (isset($this->from) && isset($this->to)) {
            $fromDatetime = new Carbon($this->from);
            $toDatetime = new Carbon($this->to);
        }

        //$oder= $this->orderAsc ? 'asc' : 'desc');

        $summary_calls_today =
            $fromDatetime != null && $toDatetime != null
            ? CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$fromDatetime, $toDatetime])
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17', 'cc-21'])
            ->groupBy('dst')
            ->orderByRaw("FIELD(dst , 'cc-3', 'cc-7', 'cc-13', 'cc-15','cc-20', 'cc-6','cc-18', 'cc-4', 'cc-14','cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12','cc-16', 'cc-17','cc-21','s','#','t') ASC")
            ->get()
            : CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17', 'cc-21'])
            ->groupBy('dst')
            ->orderByRaw("FIELD(dst , 'cc-3', 'cc-7', 'cc-13', 'cc-15','cc-20', 'cc-6','cc-18', 'cc-4', 'cc-14','cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12','cc-16', 'cc-17','cc-21','s','#','t') ASC")
            ->get();

        $speakToAnAgentCalls =
            $fromDatetime != null && $toDatetime != null
            ? CallDetailsRecordModel::select('disposition', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$fromDatetime, $toDatetime])
            ->where('dst', 'cc-16')
            ->groupBy('disposition')
            ->orderBy('y', $this->orderAsc ? 'asc' : 'desc')
            ->get()
            : CallDetailsRecordModel::select('disposition', DB::raw('count(*) as y'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->where('dst', 'cc-16')
            ->groupBy('disposition')
            ->orderBy('y', $this->orderAsc ? 'asc' : 'desc')
            ->get();

        //dd($speakToAnAgent);

        $summary_calls_customers =
            $fromDatetime != null && $toDatetime != null
            ? CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereBetween('calldate', [$fromDatetime, $toDatetime])
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->groupBy('src')
            ->get()
            : CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->groupBy('src')
            ->get();

        $total_calls_yesterday = CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereDate('calldate', \Carbon\Carbon::yesterday())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->groupBy('dst')
            ->get();

        $callsToday = $summary_calls_today->sum('y');

        // if ($fromDatetime != null && $toDatetime != null) {
        //     $this->emit('dataUpdate', [
        //         'summary_calls_today' => $summary_calls_today,
        //         'summary_calls_customers' => $summary_calls_customers,
        //         'callsToday' => $callsToday,
        //     ]);
        // }
        //if ($fromDatetime != null && $toDatetime != null) {
        $this->emit('dataUpdate', [
            'summary_calls_today' => $summary_calls_today,
            'summary_calls_customers' => $summary_calls_customers,
            'callsToday' => $callsToday,
        ]);
        //  }



        return view('livewire.reports.call-summary-records', compact('summary_calls_today', 'total_calls_yesterday', 'summary_calls_customers', 'callsToday', 'speakToAnAgentCalls'));
    }

    public function search() {}
}

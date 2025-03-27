<?php

namespace App\Http\Livewire\Reports;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithPagination;

class CallDetailRecords extends Component
{
    use WithPagination;

    public $searchTerm;
    public $totalUsers;
    public $from;
    public $to;
    public $cdrRecord_id;
    public $cdrRecord_src;
    public $cdrRecord_dcontext;
    public $calldate;
    public $hangupdate;

    public $perPage = 10;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = true;

    public $src, $dst, $dur_max, $dur_min, $src_mod, $clid;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'searchTerm' => ['except' => ''],
    ];

    public function mount()
    {
        $this->searchTerm = null;

        $this->totalUsers = User::distinct()->count('man_no');
    }

    public function render()
    {
        $fromDatetime = null;
        $toDatetime = null;

        if (isset($this->from) && isset($this->to)) {
            $fromDatetime = new Carbon($this->from);
            $toDatetime = new Carbon($this->to);
        }

        // $total_calls_today =
        //     ($fromDatetime != null && $toDatetime != null)
        //     ?
        //     CallDetailsRecordModel::select('*')
        //     ->whereBetween('calldate', [$fromDatetime, $toDatetime])
        //     ->orderBy($this->order)
        //     ->paginate(15)
        //     :
        //     CallDetailsRecordModel::select('*')
        //     ->whereDate('calldate', \Carbon\Carbon::today())
        //     ->orderBy($this->order??'calldate')
        //     ->paginate(15);

        $query = $fromDatetime != null && $toDatetime != null ? CallDetailsRecordModel::whereBetween('calldate', [$fromDatetime, $toDatetime]) : CallDetailsRecordModel::whereDate('calldate', \Carbon\Carbon::today());

        $query->orderBy($this->order ?? 'calldate');

        if ($this->src != null) {

            if ($this->src_mod == 'contains') {

                $query->where('src', 'LIKE', '%' . $this->src . '%');
            } elseif ($this->src_mod == 'begins_with') {
                $query->where('src', 'LIKE', $this->src . '%');
                $query->orWhere('src', 'LIKE', '00' . $this->src . '%');
                $query->orWhere('src', 'LIKE', '+00' . $this->src . '%');
                $query->orWhere('src', 'LIKE', '0026' . $this->src . '%');
                $query->orWhere('src', 'LIKE', '+0026' . $this->src . '%');
                //$query->orWhere('src', 'LIKE','+'.$this->src.'%');
                // $query->orWhere('src', 'LIKE', '%' . $this->src . '%');
                // $query->orWhere('src', 'LIKE', '%\^00260' . $this->src . '%');
                // $query->orWhere('src', 'LIKE', '%\^\+00260' . $this->src . '%');
            } elseif ($this->src_mod == 'ends_with') {
                $query->where('src', 'LIKE', '%' . $this->src);
            } else {

                $query->where('src', 'LIKE', '%' . $this->src . '%');
            }
        }

        if ($this->dst) {
            $query->where('dst', $this->dst);
        }

        if ($this->dur_max != null) {
            $query->where('duration', '<=', $this->dur_max);
        }

        if ($this->dur_min != null) {
            $query->where('duration', '>=', $this->dur_min);
        }

        if ($this->src != null) {
            $query->where('clid', 'LIKE', '%' . $this->clid . '%');
        }

        $query->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17']);

        $total_calls_today = $query->paginate($this->perPage);

        //$total_calls_today = $query->get();

        //dd($total_calls_today);

        //        //dd($this->from);
        //        $fromDatetime = null;// = new Carbon('2016-01-23 11:53:20');
        //        $toDatetime = null;
        //
        //        if (isset($this->from) && isset($this->to)) {
        //            $fromDatetime = new Carbon($this->from);
        //            $toDatetime = new Carbon($this->to);
        //        }
        //
        //
        //        $total_calls_today = ($fromDatetime != null && $toDatetime != null) ?
        //            CallDetailsRecordModel::whereBetween('calldate', [$fromDatetime, $toDatetime])
        //            ->paginate(15)
        //            : CallDetailsRecordModel::whereDate('calldate', Carbon::today())
        //                ->paginate(15);

        $total_calls_yesterday = CallDetailsRecordModel::whereDate('calldate', Carbon::yesterday())->count();
        $total_calls_month = CallDetailsRecordModel::whereBetween('calldate', [Carbon::now()->startOfMonth(), Carbon::now()])->count();

        $total_calls_year = CallDetailsRecordModel::whereBetween('calldate', [Carbon::now()->startOfYear(), Carbon::now()])->count();

        $total_customers =
            $fromDatetime != null && $toDatetime != null
            ? CallDetailsRecordModel::whereBetween('calldate', [$fromDatetime, $toDatetime])->get()
            : CallDetailsRecordModel::select('src')
            ->whereDate('calldate', Carbon::today())
            ->groupBy('src')
            ->count();

        return view('livewire.reports.call-detail-records', [
            'total_calls_today' => $total_calls_today,
            'total_calls_yesterday' => $total_calls_yesterday,
            'total_calls_month' => $total_calls_month,
            'total_customers' => $total_customers,
            'total_calls_year' => $total_calls_year,
            'calls' => $total_calls_today,
        ]);
    }

    public function show($id)
    {
        $cdrRecord = CallDetailsRecordModel::findOrFail($id);
        $this->cdrRecord_id = $cdrRecord->id;
        $this->cdrRecord_src = $cdrRecord->src;
        $this->cdrRecord_dcontext = $cdrRecord->myDestination->description;

        $this->calldate = $cdrRecord->calldate;

        $this->hangupdate = $cdrRecord->hangupdate;

        //dd($cdrRecord);
    }

    public function search()
    {
    }
}

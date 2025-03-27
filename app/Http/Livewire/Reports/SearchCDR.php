<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\CDR\CallDetailsRecordModel;

class SearchCDR extends Component
{
    public $from;
    public $to;
    public $updated = 'false';
    public $src;

    protected $queryString = ['src'];

    public function mount()
    {
        //$this->src = Route::current()->parameter('src');
        //dd($this->src );
    }

    public function render()
    {
        $fromDatetime = null;
        $toDatetime = null;

        if (isset($this->from) && isset($this->to)) {
            $fromDatetime = new Carbon($this->from);
            $toDatetime = new Carbon($this->to);
        }

        $summary_calls_today =
            ($fromDatetime != null && $toDatetime != null)
            ?
            CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereBetween('calldate', [$fromDatetime, $toDatetime])
            ->where('src','LIKE','%'.$this->src.'%')
            ->groupBy('dst')
            ->get()
            :
            CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->where('src','LIKE','%'.$this->src.'%')
            ->groupBy('dst')
            ->get();



        $summary_calls_customers = ($fromDatetime != null && $toDatetime != null)
            ?
            CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereBetween('calldate', [$fromDatetime, $toDatetime])
            ->where('src','LIKE','%'.$this->src.'%')
            ->groupBy('src')
            ->get()
            :
            CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->where('src','LIKE','%'.$this->src.'%')
            ->groupBy('src')
            ->get();


        $total_calls_yesterday = CallDetailsRecordModel::select('dst', DB::raw('count(*) as y'))
            ->whereDate('calldate', \Carbon\Carbon::yesterday())
            ->where('src','LIKE','%'.$this->src.'%')
            ->groupBy('dst')
            ->get();



            // dd($summary_calls_today);

            $customerJourneys =
            ($fromDatetime != null && $toDatetime != null)
                ?
                CallDetailsRecordModel::
                select('*')
                    ->whereBetween('calldate', [$fromDatetime, $toDatetime])
                    ->where('src','LIKE','%'.$this->src.'%')
                    ->paginate(15)
                :
                CallDetailsRecordModel::
                select('*')
                    ->whereDate('calldate', \Carbon\Carbon::today())
                    ->where('src','LIKE','%'.$this->src.'%')
                    ->paginate(15);

        $callsToday = $summary_calls_today->sum('y');

        if ($fromDatetime != null && $toDatetime != null) {

            $this->emit('dataUpdate', [
                'summary_calls_today' => $summary_calls_today,
                'summary_calls_customers' => $summary_calls_customers,
                'callsToday' => $callsToday

            ]);
        }

        return view(
            'livewire.reports.search-c-d-r',
            compact(
                'summary_calls_today',
                'total_calls_yesterday',
                'summary_calls_customers',
                'callsToday',
                'customerJourneys'
            )
        );
    }

    public function search()
    {

    }
}

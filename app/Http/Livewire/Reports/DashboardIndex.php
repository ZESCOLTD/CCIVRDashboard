<?php

namespace App\Http\Livewire\Reports;

use DB;
use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\CDR\CallDetailsRecordModel;


class DashboardIndex extends Component
{

    use WithPagination;

    public $searchTerm;

    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'searchTerm' => ['except' => '']
    ];
    public $totalUsers;

    public function mount()
    {
        $this->searchTerm = null;

        //        $this->totalUsers = User::distinct()->count('man_no');
    }


    public function render()
    {

        $user = Auth::user();
        //dd($user->permissions);
        //dd($user);

        $total_calls_today = CallDetailsRecordModel::whereDate('calldate', Carbon::today())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->get();


        $total_calls_yesterday = CallDetailsRecordModel::whereDate('calldate', Carbon::yesterday())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->count();


        $total_calls_month = CallDetailsRecordModel::whereBetween('calldate', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->count();
        //->whereBetween('calldate', [$fromDatetime, $toDatetime])

        $total_calls_year = CallDetailsRecordModel::whereDate('calldate', Carbon::now()->startOfYear())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->count();



        $total_customers = CallDetailsRecordModel::select('src', DB::raw('count(*) as total'))
            ->whereDate('calldate', \Carbon\Carbon::today())
            ->whereIn('dst', ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'])
            ->groupBy('src')
            ->get();



        //        $dataset = User::query();
        //
        //        $dataset->orderBy('created_at');
        //
        //
        //        if ($this->searchTerm) {
        ////        if ($this->searchTerm && strlen($this->searchTerm) >= 5) {
        //            $dataset->where(function ($query) {
        //                $query
        //                    ->orWhereRaw("LOWER(man_no) LIKE LOWER('%{$this->searchTerm }%')")
        //                    ->orWhereRaw("LOWER(name) LIKE LOWER('%{$this->searchTerm}%')");
        //            });
        //
        //            $dataset = $dataset->paginate(10);
        //        } else {
        //            $dataset = $dataset->paginate(10);
        //        }

        return view('livewire.reports.dashboard-index', compact(
            'total_calls_today',
            'total_calls_yesterday',
            'total_calls_month',
            'total_customers',
            'total_calls_year'
        ));
    }
}

<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use App\Models\CDR\CallDetailsRecordModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use DB;
use Illuminate\Support\Facades\Cache; // Import the Cache facade

class DashboardIndex extends Component
{
    use WithPagination;

    public $searchTerm;
    protected $paginationTheme = 'bootstrap';

    protected $queryString = [
        'searchTerm' => ['except' => '']
    ];

    public function mount()
    {
        $this->searchTerm = null;
    }

    public function render()
    {
        $user = Auth::user();
          // Define cache duration in seconds (1 hour = 3600 seconds)
          $cacheDuration = 3600;


        // Define reusable variables
        $dstExtensions = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'];

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $dayBeforeYesterday = Carbon::yesterday()->subDay(); // For yesterday's comparison
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth(); // For last month's comparison for customers
        $now = Carbon::now();

        // Total Calls Today
        $total_calls_today_count = CallDetailsRecordModel::whereDate('calldate', $today)
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Calls Yesterday
        $total_calls_yesterday = CallDetailsRecordModel::whereDate('calldate', $yesterday)
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Calls Day Before Yesterday (for comparison with yesterday's calls)
        $total_calls_day_before_yesterday = CallDetailsRecordModel::whereDate('calldate', $dayBeforeYesterday)
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Calls This Month
        $total_calls_month = CallDetailsRecordModel::whereBetween('calldate', [$startOfMonth, $now])
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Calls Last Month (for comparison with current month's calls)
        $total_calls_last_month = CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, Carbon::now()->subMonth()->endOfMonth()])
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Calls This Year
        $total_calls_year = CallDetailsRecordModel::whereBetween('calldate', [Carbon::now()->startOfYear(), $now])
            ->whereIn('dst', $dstExtensions)
            ->count();

        // Total Customers Today (distinct count of 'src')
        $total_customers = CallDetailsRecordModel::whereDate('calldate', $today)
            ->whereIn('dst', $dstExtensions)
            ->distinct('src')
            ->count();

        // Total Customers Last Month (for comparison with current customers)
        $total_customers_last_month = CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, Carbon::now()->subMonth()->endOfMonth()])
            ->whereIn('dst', $dstExtensions)
            ->distinct('src')
            ->count();




             // --- Chart Data Caching ---


        // Data for charts (these remain collections)
        // Daily Calls (Last 30 Days)
            $dailyCalls = Cache::remember('dailyCalls', $cacheDuration, function () use ($dstExtensions) {
                return CallDetailsRecordModel::selectRaw('DATE(calldate) as date, COUNT(*) as total')
                ->whereIn('dst', $dstExtensions)
                ->where('calldate', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            });

        $monthlyCalls = Cache::remember('monthlyCalls', $cacheDuration, function () use ($dstExtensions) {
        return CallDetailsRecordModel::selectRaw("DATE_FORMAT(calldate, '%Y-%m') as month, COUNT(*) as total")
            ->whereIn('dst', $dstExtensions)
            ->where('calldate', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        });


        $dailyCustomers =  Cache::remember('dailyCustomers', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::selectRaw('DATE(calldate) as date, COUNT(DISTINCT src) as total')
            ->whereIn('dst', $dstExtensions)
            ->where('calldate', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    });

        $todayDstDist =  Cache::remember('todayDstDist', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::select('dst', \DB::raw('COUNT(*) as total'))
            ->whereDate('calldate', Carbon::today())
            ->groupBy('dst')
            ->get();
    });

        $hourlyCalls =  Cache::remember('hourlyCalls', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::selectRaw('HOUR(calldate) as hour, COUNT(*) as total')
            ->whereDate('calldate', Carbon::today())
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
    });

        return view('livewire.reports.dashboard-index', compact(
            'total_calls_today_count', // Use this for the card count
            'total_calls_yesterday',
            'total_calls_day_before_yesterday', // Pass this for comparison
            'total_calls_month',
            'total_calls_last_month', // Pass this for comparison
            'total_calls_year',
            'total_customers', // Use this for the card count
            'total_customers_last_month', // Pass this for comparison

            'dailyCalls',
            'monthlyCalls',
            'dailyCustomers',
            'todayDstDist',
            'hourlyCalls'
        ));
    }
}
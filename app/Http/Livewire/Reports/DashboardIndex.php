<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use App\Models\CDR\CallDetailsRecordModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; // Import the Cache facade

class DashboardIndex extends Component
{
    use WithPagination;

    public $searchTerm;
    protected $paginationTheme = 'bootstrap';

    // Set default cache duration and prefix for clean keys
    protected $cacheDuration = 1800; // 30 minutes
    protected $cachePrefix = 'dashboard_metrics_';

    protected $queryString = [
        'searchTerm' => ['except' => '']
    ];

    public function mount()
    {
        $this->searchTerm = null;

        $user = Auth::user();

        if ($user->hasRole('agent') && $user->getRoleNames()->count()==1) {
            return redirect()->route('live.agent.dashboard', ['id' => $user->id]);
        }
    }

    /**
     * Helper function to wrap count queries in a cache layer.
     * This ensures the database is only hit once every $cacheDuration seconds for static data.
     */
    protected function cachedCount(string $key, \Closure $callback)
    {
        return Cache::remember($this->cachePrefix . $key, $this->cacheDuration, $callback);
    }

    public function render()
    {

        $user = Auth::user();

        // Define reusable variables
        $dstExtensions = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'];

        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $dayBeforeYesterday = Carbon::yesterday()->subDay();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $now = Carbon::now();

        // 1. Total Calls Today (Keep direct for real-time freshness)
        $total_calls_today_count = CallDetailsRecordModel::whereDate('calldate', $today)
            ->whereIn('dst', $dstExtensions)
            ->count();

        // 2. Total Calls Yesterday (Cached)
        $total_calls_yesterday = $this->cachedCount('calls_yesterday', function () use ($yesterday, $dstExtensions) {
            return CallDetailsRecordModel::whereDate('calldate', $yesterday)
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 3. Total Calls Day Before Yesterday (Cached)
        $total_calls_day_before_yesterday = $this->cachedCount('calls_day_before_yesterday', function () use ($dayBeforeYesterday, $dstExtensions) {
            return CallDetailsRecordModel::whereDate('calldate', $dayBeforeYesterday)
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 4. Total Calls This Month (Cached, refreshes every 30 mins)
        $total_calls_month = $this->cachedCount('calls_this_month', function () use ($startOfMonth, $now, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfMonth, $now])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 5. Total Calls Last Month (Cached - value is static, can be cached aggressively)
        $total_calls_last_month = $this->cachedCount('calls_last_month', function () use ($startOfLastMonth, $endOfLastMonth, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, $endOfLastMonth])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 6. Total Calls This Year (Cached)
        $total_calls_year = $this->cachedCount('calls_this_year', function () use ($startOfYear, $now, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfYear, $now])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 7. Total Customers Today (Keep direct for real-time freshness)
        $total_customers = CallDetailsRecordModel::whereDate('calldate', $today)
            ->whereIn('dst', $dstExtensions)
            ->distinct('src')
            ->count('src');

        // 8. Total Customers Last Month (Cached - value is static, can be cached aggressively)
        $total_customers_last_month = $this->cachedCount('customers_last_month', function () use ($startOfLastMonth, $endOfLastMonth, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, $endOfLastMonth])
                ->whereIn('dst', $dstExtensions)
                ->distinct('src')
                ->count('src');
        });


        // --- Chart Data Caching ---
        // These blocks already used Caching, but I've updated them to use the $this->cacheDuration property for consistency
        $cacheDuration = $this->cacheDuration;

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


        $dailyCustomers = Cache::remember('dailyCustomers', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::selectRaw('DATE(calldate) as date, COUNT(DISTINCT src) as total')
                ->whereIn('dst', $dstExtensions)
                ->where('calldate', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        $todayDstDist = Cache::remember('todayDstDist', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::select('dst', \DB::raw('COUNT(*) as total'))
                ->whereDate('calldate', Carbon::today())
                ->whereIn('dst', $dstExtensions)
                ->groupBy('dst')
                ->get();
        });

        $hourlyCalls = Cache::remember('hourlyCalls', $cacheDuration, function () use ($dstExtensions) {
            return CallDetailsRecordModel::selectRaw('HOUR(calldate) as hour, COUNT(*) as total')
                ->whereDate('calldate', Carbon::today())
                ->whereIn('dst', $dstExtensions)
                ->groupBy('hour')
                ->orderBy('hour')
                ->get();
        });

        return view('livewire.reports.dashboard-index', compact(
            'total_calls_today_count',
            'total_calls_yesterday',
            'total_calls_day_before_yesterday',
            'total_calls_month',
            'total_calls_last_month',
            'total_calls_year',
            'total_customers',
            'total_customers_last_month',

            'dailyCalls',
            'monthlyCalls',
            'dailyCustomers',
            'todayDstDist',
            'hourlyCalls'
        ));
    }
}

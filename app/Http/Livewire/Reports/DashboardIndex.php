<?php
namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use App\Models\CDR\CallDetailsRecordModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardIndex extends Component
{
    use WithPagination;

    public $searchTerm;
    protected $paginationTheme = 'bootstrap';
    protected $cacheDuration = 1800;
    protected $cachePrefix = 'dashboard_metrics_';

    protected $queryString = ['searchTerm' => ['except' => '']];

    public function render()
    {
        $dstExtensions = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17'];

        // Define Start/End ranges to trigger Index usage (Crucial)
        $todayS = Carbon::today()->startOfDay();
        $todayE = Carbon::today()->endOfDay();

        $yesterdayS = Carbon::yesterday()->startOfDay();
        $yesterdayE = Carbon::yesterday()->endOfDay();

        $dbYesterdayS = Carbon::yesterday()->subDay()->startOfDay();
        $dbYesterdayE = Carbon::yesterday()->subDay()->endOfDay();

        $startOfMonth = Carbon::now()->startOfMonth();
        $now = Carbon::now();

        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        // 1. Total Calls Today (Using whereBetween instead of whereDate)
        $total_calls_today_count = CallDetailsRecordModel::whereBetween('calldate', [$todayS, $todayE])
            ->whereIn('dst', $dstExtensions)
            ->count();

        // 2. Total Calls Yesterday (Cached)
        $total_calls_yesterday = $this->cachedCount('calls_yesterday', function () use ($yesterdayS, $yesterdayE, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$yesterdayS, $yesterdayE])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 3. Total Calls Day Before Yesterday (Cached)
        $total_calls_day_before_yesterday = $this->cachedCount('calls_day_before_yesterday', function () use ($dbYesterdayS, $dbYesterdayE, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$dbYesterdayS, $dbYesterdayE])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 4. Total Calls This Month
        $total_calls_month = $this->cachedCount('calls_this_month', function () use ($startOfMonth, $now, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfMonth, $now])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 5. Total Calls Last Month
        $total_calls_last_month = $this->cachedCount('calls_last_month', function () use ($startOfLastMonth, $endOfLastMonth, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, $endOfLastMonth])
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        // 7. Total Customers Today (Optimization: use a raw count distinct for speed)
        $total_customers = CallDetailsRecordModel::whereBetween('calldate', [$todayS, $todayE])
            ->whereIn('dst', $dstExtensions)
            ->distinct()
            ->count('src');

        // 8. Total Customers Last Month (Cached)
        $total_customers_last_month = $this->cachedCount('customers_last_month', function () use ($startOfLastMonth, $endOfLastMonth, $dstExtensions) {
            return CallDetailsRecordModel::whereBetween('calldate', [$startOfLastMonth, $endOfLastMonth])
                ->whereIn('dst', $dstExtensions)
                ->distinct()
                ->count('src');
        });

        return view('livewire.reports.dashboard-index', [
            'total_calls_today_count' => $total_calls_today_count,
            'total_calls_yesterday' => $total_calls_yesterday,
            'total_calls_day_before_yesterday' => $total_calls_day_before_yesterday,
            'total_calls_month' => $total_calls_month,
            'total_calls_last_month' => $total_calls_last_month,
            'total_customers' => $total_customers,
            'total_customers_last_month' => $total_customers_last_month,
        ]);
    }

    protected function cachedCount(string $key, \Closure $callback)
    {
        return Cache::remember($this->cachePrefix . $key, $this->cacheDuration, $callback);
    }
}

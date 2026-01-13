<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\UssdSession;
use App\Models\OtherChannel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
// 1. ADD CACHE FACADE
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\AnalyticsController;
use App\Services\GoogleAnalyticsService;



class DailyStatsSummary extends Component
{

    public $channels = [];
    public $selectedChannel = '';
    public $channelTotal = '';
    public $statsDate = '';
    public $loading = false;
    public $channel_name, $channel_date, $total;
    public string $editNetwork = '';
    public int $editSessions = 0;


    // 🌟 NEW PROPERTY FOR USER INPUT
    public string $selectedDate;


    protected $rules = [
        'channel_name' => 'required|string|max:255',
        'channel_date' => 'required|date',
        'total' => 'required|integer|min:0',
    ];

    public function mount()
    {
        // Load your channels from DB or config
        $this->channels = ['Website', 'Mobile App'];

        // 🌟 INITIALIZE WITH YESTERDAY'S DATE AS DEFAULT
        $this->selectedDate = Carbon::yesterday()->toDateString();
        // $this->selectedDate = Carbon::today()->subDays(2)->toDateString();
    }
    public function refreshStats()
    {
        // Livewire automatically calls render() after this method completes.
        // The process of this method running will trigger the wire:loading state.
        // You can add a sleep(1) here if you want to simulate a longer loading time for testing.
    }


    function getStatsActiveUsersForWebsite(string $startDate, string $endDate, $metricValue = 'activeUsers')
    {

        $analyticsService = new GoogleAnalyticsService();
        $propertyId = '337673843';

        // For last week (replace with actual dates)
        $totalLastWeek = $analyticsService->getTotalUsersByDateRange($propertyId, $startDate, $endDate, $metricValue);

        return response()->json([
            'metric' => $metricValue,
            'total' => $totalLastWeek,
        ]);
    }


    /**
     * Get stats for a specific date from a given Eloquent model (USSD sessions).
     */
    private function getStatsForDate(string $modelClass, string $date): Collection
    {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("{$modelClass} is not a valid Eloquent model.");
        }

        return $modelClass::selectRaw('network, COUNT(*) as sessions')
            ->whereDate('created_at', $date)
            ->groupBy('network')
            ->get()
            ->keyBy('network');
    }

    /**
     * Get stats for OtherChannel networks.
     */
    private function getStatsForDateOtherChannel(string $modelClass, string $date): Collection
    {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("{$modelClass} is not a valid Eloquent model.");
        }

        return $modelClass::selectRaw('channel_name as network, SUM(total) as sessions')
            ->whereDate('channel_date', $date)
            ->groupBy('channel_name')
            ->get()
            ->keyBy('network');
    }

    /**
     * Get stats for Mobile App or Website from Oracle DB.
     *
     * @param string|Carbon $date
     * @param int $system_id
     * @return object|null
     */
    private function getStatsForMobileAppDate($date, int $system_id)
    {
        $dateString = Carbon::parse($date)->format('Y-m-d');

        return DB::connection('omni_channel')
            ->table('M_APPS_COMPLAINTS')
            ->selectRaw('SYSTEM_ID, COUNT(*) as count')
            ->whereRaw('TRUNC("F_ACTUAL") = TO_DATE(?, \'YYYY-MM-DD\')', [$dateString])
            ->where('SYSTEM_ID', '=', $system_id)
            ->groupBy('SYSTEM_ID')
            ->first(); // single row, not collection
    }

    public function render()
    {
        // Dates
        $selectedDateCarbon = Carbon::parse($this->selectedDate);
        $yesterday = $selectedDateCarbon->toDateString();
        $dayBeforeYesterday = $selectedDateCarbon->subDay()->toDateString();

        // IVR Extensions (remains the same)
        $dstExtensions = [
            'cc-3',
            'cc-4',
            'cc-6',
            'cc-7',
            'cc-8',
            'cc-9',
            'cc-10',
            'cc-11',
            'cc-12',
            'cc-13',
            'cc-14',
            'cc-15',
            'cc-16',
            'cc-17',
            'cc-18',
            'cc-20'
        ];

        // Fetch raw stats (USSD/Other are fast, keep them as is)
        $ussdToday = $this->getStatsForDate(UssdSession::class, $yesterday);
        $ussdYesterday = $this->getStatsForDate(UssdSession::class, $dayBeforeYesterday);

        // $otherToday = $this->getStatsForDateOtherChannel(OtherChannel::class, $yesterday);
        // $otherYesterday = $this->getStatsForDateOtherChannel(OtherChannel::class, $dayBeforeYesterday);

        // 2. APPLY CACHING TO SLOW OPERATIONS (Oracle DB and Google Analytics)

        // Cache Mobile App/Oracle DB calls for 60 minutes (3600 seconds)
        $mobileAppToday = Cache::remember("mobile_app_today_{$yesterday}", 3600, function () use ($yesterday) {
            return $this->getStatsForMobileAppDate($yesterday, 100);
        });

        $mobileAppYesterday = Cache::remember("mobile_app_yesterday_{$dayBeforeYesterday}", 3600, function () use ($dayBeforeYesterday) {
            return $this->getStatsForMobileAppDate($dayBeforeYesterday, 100);
        });

        // Cache Website/Google Analytics calls for 60 minutes (3600 seconds)
        $websiteToday = Cache::remember("website_today_{$yesterday}", 3600, function () use ($yesterday) {
            // Note: Since getStatsActiveUsersForWebsite returns a JsonResponse, we call it here.
            return $this->getStatsActiveUsersForWebsite($yesterday, $yesterday, 'activeUsers');
        });

        $websiteYesterday = Cache::remember("website_yesterday_{$dayBeforeYesterday}", 3600, function () use ($dayBeforeYesterday) {
            return $this->getStatsActiveUsersForWebsite($dayBeforeYesterday, $dayBeforeYesterday, 'activeUsers');
        });

        // dd([$websiteToday, $websiteYesterday]); // Commented dd is fine

        // Normalize function for all types of data (remains the same)
        $normalize = function ($data) {
            // ... (normalize logic remains the same) ...
            if ($data instanceof \Illuminate\Http\JsonResponse) {
                $decoded = json_decode($data->getContent(), true);

                // Transform the array
                $transformed = [];
                if (isset($decoded['metric']) && isset($decoded['total'])) {
                    // Map the metric to the desired key
                    $key = 'count';
                    $transformed[$key] = $decoded['total'];
                }

                return $transformed;
            }

            if ($data instanceof \Illuminate\Support\Collection) {
                return $data->mapWithKeys(function ($item, $key) {
                    if (is_array($item)) return [$key => $item['sessions'] ?? 0];
                    if (is_object($item)) return [$key => $item->sessions ?? 0];
                    return [$key => 0];
                })->toArray();
            }

            if (is_object($data) && property_exists($data, 'count')) {
                return ['count' => $data->count];
            }

            if (is_array($data) && isset($data['count'])) {
                return $data;
            }

            return ['count' => 0];
        };

        // Normalize all stats (remains the same)
        $stats = [
            'today' => [
                'USSD' => $normalize($ussdToday),
                // 'Other' => $normalize($otherToday),
                'Mobile App' => $normalize($mobileAppToday),
                'Website' => $normalize($websiteToday),
            ],
            'yesterday' => [
                'USSD' => $normalize($ussdYesterday),
                // 'Other' => $normalize($otherYesterday),
                'Mobile App' => $normalize($mobileAppYesterday),
                'Website' => $normalize($websiteYesterday),
            ],
        ];

        // Merge networks and compute changes (remains the same)
        $allNetworks = collect(array_keys($stats['today']['USSD']))
            ->merge(array_keys($stats['yesterday']['USSD']))
            // ->merge(array_keys($stats['today']['Other']))
            // ->merge(array_keys($stats['yesterday']['Other']))
            ->merge(['Mobile App', 'Website'])
            ->unique();

        $merged = $allNetworks->map(function ($network) use ($stats) {
            // ... (Mapping and change calculation logic remains the same) ...
            $todayTotal = 0;
            $yesterdayTotal = 0;
            $manual = 'no';


            if (in_array($network, ['Mobile App', 'Website'])) {
                $todayTotal = (int)($stats['today'][$network]['count'] ?? 0);
                $yesterdayTotal = (int)($stats['yesterday'][$network]['count'] ?? 0);
            } else {
                $todayUssd = $stats['today']['USSD'][$network] ?? 0;
                $yesterdayUssd = $stats['yesterday']['USSD'][$network] ?? 0;

                $todayOther = $stats['today']['Other'][$network] ?? 0;
                $yesterdayOther = $stats['yesterday']['Other'][$network] ?? 0;

                $todayTotal = $todayUssd + $todayOther;
                $yesterdayTotal = $yesterdayUssd + $yesterdayOther;

                $manual = ($todayOther + $yesterdayOther) > 0 ? 'yes' : 'no';
            }

            $change = $yesterdayTotal > 0
                ? (($todayTotal - $yesterdayTotal) / $yesterdayTotal) * 100
                : ($todayTotal > 0 ? 100 : 0);



            return (object)[
                'network' => $network,
                'sessions' => $todayTotal,
                'previous' => $yesterdayTotal,
                'change' => round($change, 2),
                'manual_edit' => $manual,
            ];
        });

        // dd($merged);

        // Cache IVR stats
        $ivrYesterday = Cache::remember("ivr_yesterday_{$yesterday}", 3600, function () use ($yesterday, $dstExtensions) {
            return CallDetailsRecordModel::whereDate('calldate', $yesterday)
                ->whereIn('dst', $dstExtensions)
                ->count();
        });

        $ivrDayBefore = Cache::remember("ivr_day_before_{$dayBeforeYesterday}", 3600, function () use ($dayBeforeYesterday, $dstExtensions) {
            return CallDetailsRecordModel::whereDate('calldate', $dayBeforeYesterday)
                ->whereIn('dst', $dstExtensions)
                ->count();
        });


        $ivrChange = $ivrDayBefore > 0
            ? (($ivrDayBefore - $ivrYesterday) / $ivrYesterday) * 100
            : ($ivrDayBefore > 0 ? 100 : 0);

        $merged->push((object)[
            'network' => 'IVR',
            'sessions' => $ivrDayBefore,
            'previous' => $ivrYesterday,
            'change' => round($ivrChange, 2),
            'manual_edit' => 'no',
        ]);

        // dd($merged->values()) ; // THE ORIGINAL PROBLEM LINE HAS BEEN REMOVED/COMMENTED OUT


        return view('livewire.dashboard.daily-stats-summary', [
            'dailyStats' => $merged->values(),
        ]);
    }



    public function save()
    {
        $this->validate();

        OtherChannel::create([
            'channel_name' => $this->channel_name,
            'channel_date' => $this->channel_date,
            'total' => $this->total,
        ]);

        session()->flash('message', 'Channel entry saved successfully.');

        $this->reset(['channel_name', 'channel_date', 'total']);
    }


    public function submit()
    {
        $this->loading = true;

        // Validate input
        $this->validate([
            'selectedChannel' => 'required|string',
            'channelTotal' => 'required|numeric',
            'statsDate' => 'required|date',
        ]);

        // Example logic to update or insert
        OtherChannel::updateOrCreate(
            [
                'channel_name' => $this->selectedChannel,
                'channel_date' => $this->statsDate,
                'total' => $this->channelTotal,
            ],
            [
                'channel_name' => $this->selectedChannel,
                'channel_date' => $this->statsDate,
                'total' => $this->channelTotal,
            ]
        );

        // Reset inputs
        $this->reset(['selectedChannel', 'channelTotal', 'statsDate']);
        $this->loading = false;

        // Refresh component (optional)
        $this->dispatchBrowserEvent('close-modal');
        $this->emitSelf('$refresh');

        session()->flash('message', 'Daily stats summary updated successfully.');

        return redirect()->to(request()->header('Referer'));
    }


    public function edit(string $network)
    {
        $this->editNetwork = $network;

        // Load current session value from OtherChannel model
        $total = OtherChannel::where('channel_name', $network)
            ->whereDate('channel_date', now()->subDays(1)->toDateString())
            ->sum('total');

        $this->editSessions = $total;
    }

    public function update()
    {
        $network = $this->editNetwork;
        $newValue = $this->editSessions;

        // Update all rows for that day and channel (adjust logic as needed)
        OtherChannel::where('channel_name', $network)
            ->whereDate('channel_date', now()->subDays(2)->toDateString())
            ->update(['total' => $newValue]);

        session()->flash('message', 'Session value updated.');

        // Close modal using browser event
        $this->dispatchBrowserEvent('hide-modal');
    }
}

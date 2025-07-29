<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\CDR\CallDetailsRecordModel;
use App\Models\UssdSession;
use App\Models\OtherChannel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Livewire\Component;

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


    protected $rules = [
        'channel_name' => 'required|string|max:255',
        'channel_date' => 'required|date',
        'total' => 'required|integer|min:0',
    ];

    public function mount()
    {
        // Load your channels from DB or config
        // $this->channels = ['Website', 'Mobile App', 'Social Media', 'Email', 'SMS', 'IVR', 'USSD', 'Other'];
        $this->channels = ['Website', 'Mobile App'];
    }

    /**
     * Get stats for a specific date from the given model class.
     *
     * @param string $modelClass
     * @param string $date
     * @return Collection
     * @throws InvalidArgumentException
     */
    function getStatsForDate(string $modelClass, string $date): Collection
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

    function getStatsForDateOtherChannel(string $modelClass, string $date): Collection
    {
        if (!is_subclass_of($modelClass, Model::class)) {
            throw new InvalidArgumentException("{$modelClass} is not a valid Eloquent model.");
        }

        return $modelClass::selectRaw('channel_name as network, SUM(total) as sessions')
            ->whereDate('channel_date', $date)
            ->groupBy('channel_name')
            ->get()
            ->keyBy('network'); // consistent key as 'network'
    }



    public function render()
    {
        // Dates
        $yesterday = Carbon::yesterday()->toDateString();
        $dayBeforeYesterday = Carbon::yesterday()->subDay()->toDateString();

        // IVR Extensions
        $dstExtensions = ['cc-3', 'cc-4', 'cc-6', 'cc-7', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-13', 'cc-14', 'cc-15', 'cc-16', 'cc-17', 'cc-18', 'cc-20'];

        // Get data from each source
        $ussdToday = self::getStatsForDate(UssdSession::class, $dayBeforeYesterday);
        $ussdYesterday =  self::getStatsForDate(UssdSession::class, $yesterday);

        $otherToday =  self::getStatsForDateOtherChannel(OtherChannel::class, $dayBeforeYesterday);
        $otherYesterday =  self::getStatsForDateOtherChannel(OtherChannel::class, $yesterday);

        // Merge all networks
        $allNetworks = $ussdToday->keys()
            ->merge($ussdYesterday->keys())
            ->merge($otherToday->keys())
            ->merge($otherYesterday->keys())
            ->unique();

        $merged = $allNetworks->map(function ($network) use ($ussdToday, $ussdYesterday, $otherToday, $otherYesterday) {
            $todayUssd = $ussdToday[$network]->sessions ?? 0;
            $yesterdayUssd = $ussdYesterday[$network]->sessions ?? 0;

            $todayOther = $otherToday[$network]->sessions ?? 0;
            $yesterdayOther = $otherYesterday[$network]->sessions ?? 0;

            $todayTotal = $todayUssd + $todayOther;
            $yesterdayTotal = $yesterdayUssd + $yesterdayOther;

            $change = $todayTotal > 0
                ? (($yesterdayTotal - $todayTotal) / $todayTotal) * 100
                : ($yesterdayTotal > 0 ? 100 : 0);

            // Determine manual_edit flag
            $isManual = ($todayOther + $yesterdayOther) > 0 ? 'yes' : 'no';

            return (object)[
                'network' => $network,
                'sessions' => $todayTotal,
                'previous' => $yesterdayTotal,
                'change' => round($change, 2),
                'manual_edit' => $isManual,
            ];
        });

        // IVR stats
        $ivrYesterday = CallDetailsRecordModel::whereDate('calldate', $yesterday)
            ->whereIn('dst', $dstExtensions)
            ->count();

        $ivrDayBefore = CallDetailsRecordModel::whereDate('calldate', $dayBeforeYesterday)
            ->whereIn('dst', $dstExtensions)
            ->count();

        $ivrChange = $ivrYesterday > 0
            ? (($ivrDayBefore - $ivrYesterday) / $ivrYesterday) * 100
            : ($ivrDayBefore > 0 ? 100 : 0);

        $ivrStat = (object)[
            'network' => 'IVR',
            'sessions' => $ivrDayBefore,
            'previous' => $ivrYesterday,
            'change' => round($ivrChange, 2),
            'manual_edit' => 'no', // Explicitly set as 'no'
        ];

        $merged->push($ivrStat);

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

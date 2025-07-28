<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Illuminate\Support\Carbon;
use Livewire\Component;

class HourlyNetworkChart extends Component
{


    public function refresh()
    {
        $data = $this->generate();
        $this->emit('refresh', $data['hours'], $data['dataset']);
    }


    public function render()
    {
       $data = $this->generate();
        return view('livewire.dashboard.hourly-network-chart', $data);
    }

    private function generate()
{
    $sessions = UssdSession::selectRaw("network, to_char(created_at,'HH24') as hour, COUNT(*) as count")
        ->whereDate('created_at', now()->subDay())
        ->groupByRaw("network, to_char(created_at,'HH24')")
        ->orderByRaw("to_char(created_at,'HH24') ASC")
        ->get()
        ->groupBy('network');

    $time = Carbon::createFromTimeString('00:00:00');
    $hours = [];

    for ($counter = 0; $counter < 24; $counter++) {
        $hours[] = $time->format('H');
        $time->addHour();
    }

    $dataset = [];

    foreach ($sessions as $network => $session) {
        $data = [];
        foreach ($hours as $hour) {
            $record = $session->where('hour', $hour)->first();
            $data[] = $record ? (int) $record->count : 0;
        }

      // Fix for PHP 7.x
    switch (strtolower($network)) {
        case 'airtel': $color = '#F70000'; break;
        case 'mtn': $color = '#FFCB05'; break;
        case 'zamtel': $color = '#20AC49'; break;
        case 'whatsapp': $color = '#34B7F1'; break;
        default: $color = null;
    }

        $dataset[] = [
            'name' => ucfirst($network),
            'data' => $data,
            'color' => $color,
        ];
    }

    return compact('hours', 'dataset');
}

}

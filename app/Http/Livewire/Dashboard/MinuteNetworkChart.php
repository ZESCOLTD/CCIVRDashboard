<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Illuminate\Support\Carbon;
use Livewire\Component;

class MinuteNetworkChart extends Component
{

    public function refresh(){
        $data = $this->generate();
        $this->emit('refresh_minutes',$data['minutes'], $data['dataset'] );
    }

    public function render()
    {
        $data = $this->generate();
//        dd($data);
        return view('livewire.dashboard.minute-network-chart', $data);
    }

    private function generate()
{
    $sessions = UssdSession::selectRaw("network, to_char(created_at,'MI') as minute, COUNT(*) as count")
        ->whereBetween('created_at', [
            now()->copy()->minute(0)->second(0),
            now()->copy()->minute(59)->second(59)
        ])
        ->groupByRaw("network, to_char(created_at,'MI')")
        ->orderByRaw("to_char(created_at,'MI') ASC")
        ->get()
        ->groupBy('network');

    $time = Carbon::createFromTimeString('00:00:00');
    $minutes = [];

    for ($counter = 0; $counter < 60; $counter++) {
        $minutes[] = $time->format('i'); // '00', '01', ..., '59'
        $time->addMinute();
    }

    $dataset = [];

    foreach ($sessions as $network => $session) {
        $data = [];
        foreach ($minutes as $minute) {
            $record = $session->where('minute', $minute)->first();
            $data[] = $record ? (int) $record->count : 0;
        }

        // PHP 7.x compatible color switch
        switch (strtolower($network)) {
            case 'airtel':
                $color = '#F70000';
                break;
            case 'mtn':
                $color = '#FFCB05';
                break;
            case 'zamtel':
                $color = '#20AC49';
                break;
            case 'whatsapp':
                $color = '#34B7F1';
                break;
            default:
                $color = null;
        }

        $dataset[] = [
            'name' => ucfirst($network),
            'data' => $data,
            'color' => $color,
        ];
    }

    return compact('minutes', 'dataset');
}

}

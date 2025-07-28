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

    private function generate(){
        $sessions = UssdSession::
        selectRaw("network, to_char(created_at,'MI') as hour, COUNT(*) as count")
//            ->whereRaw('created_at >= (sysdate-1/24)')
            ->whereBetween('created_at', [now()->minute(0)->second(0), now()->minute(59)->second(59)])
            ->groupByRaw("network, to_char(created_at,'MI')")
            ->orderByRaw("to_char(created_at,'MI') ASC")
            ->get()
            ->groupBy('network');

        $time = Carbon::createFromTimeString('00:00:00');
        $minutes = [];

        $dataset = [];
        for ($counter = 0; $counter < 60; $counter++) {

            $minutes[] = $time->format('i');
            $time->addMinute();
        }

        foreach ($sessions as $network => $session) {
            $data = [];
            foreach ($minutes as $minute) {
                $sess = $session->where('hour', $minute)->first();
                $data[] = $sess ? $sess->count : null;
            }

            $color = null;
            switch ($network){
                case 'airtel': $color = '#F70000';break;
                case 'mtn': $color = '#FFCB05';break;
                case 'zamtel': $color = '#20AC49';break;
                case 'whatsapp': $color = '#34B7F1';break;

            }

            $set = [
                'type' => 'line',
                'data' => $data,
                'background' => 'transparent',
                'borderColor' => $color,
                'pointBorderColor' => $color,
                'pointBackgroundColor' => $color,
                'fill' => false,
                'pointHoverBackgroundColor' => '#007bff',
                'pointHoverBorderColor' => '#007bff'
            ];
            $dataset[] = $set;
        }
        return compact('minutes','dataset');
    }
}

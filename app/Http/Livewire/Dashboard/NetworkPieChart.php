<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\UssdSession;
use Livewire\Component;

class NetworkPieChart extends Component
{
    public $sessions;

    public function render()
    {
        $sessions = UssdSession::selectRaw('network, COUNT(network) as count')
            ->whereDate('created_at', now())
            ->groupBy('network')
            ->orderBy('network', 'ASC')
            ->get();

        $total = $sessions->sum('count');

        $data = [];

        foreach ($sessions as $session) {
            $network = strtolower($session->network);
            $color = null;

            // PHP 7.x compatible color switch
            switch ($network) {
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

            $data[] = [
                'name' => ucfirst($network),
                'y' => (int) $session->count,
                'color' => $color,
            ];
        }

        return view('livewire.dashboard.network-pie-chart', compact('data', 'total'));
    }

}

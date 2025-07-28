<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class HourlyNetworkAnalysis extends Component
{
    public $dataset = [];
    public $hours = [];

    public function mount($dataset, $hours)
    {
        $this->dataset = $dataset;
        $this->hours = $hours;
    }

    public function render()
    {
        return view('livewire.dashboard.hourly-network-analysis');
    }
}

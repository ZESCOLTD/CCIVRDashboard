<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class DashboardPage extends Component
{
    public function render()
    {
        return view('livewire.pages.dashboard-page')
            ->layout('layouts.main');
    }
}

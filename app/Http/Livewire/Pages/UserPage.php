<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Livewire\Component;

class UserPage extends Component
{
    public $selectedUser;
    public function render()
    {
        $users = User::all();
        return view('livewire.pages.user-page',compact('users'))
            ->layout('layouts.main');
        ;
    }

    public function select(){

    }
}

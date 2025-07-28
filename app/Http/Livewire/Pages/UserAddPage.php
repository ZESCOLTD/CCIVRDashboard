<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use PhpParser\Node\Stmt\Return_;

class UserAddPage extends Component
{
    public $man_number, $firstname, $lastname, $email, $password;

    protected $rules = [
        'man_number' => 'required|string|unique:users,man_number',
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required',
    ];

    public function render()
    {
        return view('livewire.pages.user-add-page')
            ->layout('layouts.main');

    }

    public function save()
    {
        $this->validate();
        $user = User::create([
            'man_number' => $this->man_number,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        $user->save();
        return Redirect::route('users')->with('message', 'User Added successfully');
    }
}

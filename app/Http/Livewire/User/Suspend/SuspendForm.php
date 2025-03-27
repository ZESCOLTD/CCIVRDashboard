<?php

namespace App\Http\Livewire\User\Suspend;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SuspendForm extends Component
{
    public $selectedDate;

    public User $user;

    protected $rules = [
        'selectedDate' => ['required', 'date']
    ];

    public function render()
    {
        return view('livewire.user.suspend.suspend-form');
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function submit()
    {
        User::where('id', $this->user->id)
            ->update(['banned_until' => $this->selectedDate]);

        return Redirect::route('suspend.index')
            ->with('message', 'Suspended successfully');
    }
}

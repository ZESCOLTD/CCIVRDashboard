<?php

namespace App\Http\Livewire\User\Suspend;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SuspendAllForm extends Component
{
    public $selectedDate;

    protected $rules = [
        'selectedDate' => ['required','date']
    ];

    public function render()
    {
        return view('livewire.user.suspend.suspend-all-form');
    }

    public function submit(){

        User::where('id', '!=', Auth::user()->id)
            ->update(['banned_until' => $this->selectedDate]);

        return Redirect::route('suspend.index')
            ->with('message', 'Suspended successfully');
    }
}

<?php

namespace App\Http\Livewire\Session;

use App\Models\Live\CallSession;
use Livewire\Component;

class CallSessionsController extends Component
{


    public $name;
    public $description;
    public $time_from;
    public $time_to;

    protected $rules = [
        'name' => 'required',
        'description' => 'required',
        'time_from' => 'required',
        'time_to' => 'required'
    ];

    public function render()
    {
        $sessions = CallSession::get();

        return view('livewire.session.call-sessions-controller', ['sessions' => $sessions]);
    }

    public function store()
    {


        $callSession = CallSession::create([
            'name' => $this->name,
            'description' => $this->description,
            'time_from' => $this->time_from,
            'time_to' => $this->time_to
        ]);
        session()->flash('success', 'Call session create successfully!');
    }
}

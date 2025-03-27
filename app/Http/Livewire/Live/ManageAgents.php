<?php

namespace App\Http\Livewire\Live;

use App\Models\Live\CCAgent;
use App\Models\User;
use App\Services\PBX\GetSetNumbersService;
use Livewire\Component;

class ManageAgents extends Component
{

    public $agent_name;
    public $agent_endpoint;
    public $agent_man_no;
    public $agent_user_id;
    public $agent_status;
    public $agent_state;
    public  $agent_set_number;

    public $selected;
    public $search;

    // Validation Rules
    protected $rules = [

        'agent_man_no' => 'required',
        'agent_name' => 'required',
        'agent_endpoint' => 'required',
        'agent_user_id' => 'required'
    ];

    // public function mount($id)
    // {
    //     $this->selected = $id;
    // }

    public function render()
    {


        $query = CCAgent::query();
        // ::with('agent')->orderBy('created_at', 'DESC');

        if ($this->search) {
            $search = strtolower($this->search);
            $query->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(man_no) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(name) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(endpoint) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(state) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(status) like ?', ['%' . $search . '%'])
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
                    });
            });
        }

        $agents =  $query->paginate(10);

        return view('livewire.live.manage.manage-agents', ['agents' => $agents]);
    }

    public function create()
    {
        //dd([$this->agent_name, $this->endpoint, $this->man_no]);

        CCAgent::updateOrCreate(
            [
                'man_no' => $this->agent_man_no
            ],
            [
                'man_no' => $this->agent_man_no,
                'name' => $this->agent_name,
                'endpoint' => $this->agent_endpoint,
                'user_id' => $this->agent_user_id,
                'set_number' => $this->agent_set_number,
                'state' => $this->agent_status,
                'status' => $this->agent_state
            ]
        );
        session()->flash('success', 'Agent created successfully.');
    }

    public function updatedAgentManNo()
    {
        $user = User::where('man_no', $this->agent_man_no)->first();
        if ($user != null) {
            $this->agent_name = $user->name;
            $this->agent_user_id = $user->id;
        }
    }


    public function getSetNumbers()
    {
        $setNumbers = new GetSetNumbersService();
        $setNumbers->getSetNumbers();
        session()->flash('success', 'Agent Set Numbers Synced successfully.');
    }
}

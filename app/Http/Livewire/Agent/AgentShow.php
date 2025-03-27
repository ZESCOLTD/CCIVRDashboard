<?php

namespace App\Http\Livewire\Agent;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\Live\CCAgent;
use App\Models\Live\Recordings;
use App\Models\Live\TransactionCode;
use App\Models\Live\Recordings as LiveRecordings;

class AgentShow extends Component
{
    public $agent;

    public $agent_name;
    public $agent_man_no;
    public $agent_endpoint;
    public $agent_state;
    public $agent_set_number;
    public $agent_user_id;
    public $agent_status, $rec_title;

    public $from, $to;

    public $totalRecords;

    public $t_code;
    public $transactionCodes = [];
    public $recording;

    public $search;


    public function mount($id)
    {

        $this->agent = CCAgent::find($id);

        $this->transactionCodes = TransactionCode::all();
        $this->agent->name = $this->agent_name = $this->agent->name;
        $this->agent_man_no = $this->agent->man_no;
        $this->agent_endpoint = $this->agent->endpoint;
        $this->agent_state = $this->agent->state;

        $this->agent_set_number = $this->agent->set_number;
        $this->agent_user_id = $this->agent->user_id;
        $this->agent_status = $this->agent->status;
    }
    public function render()
    {
        $this->rec_title = "Recordings Today";
        $recordings = self::filterRecordings();
        return view('livewire.agent.agent-show', ['agent' => $this->agent, 'recordings' => $recordings]);
    }

    public function remove()
    {


        CCAgent::where('id', $this->agent->id)->delete();
        // Flash success message
        session()->flash('success', 'Agent deleted successfully!');
    }

    public function edit()
    {

        $this->agent->name = $this->agent_name;
        $this->agent->man_no = $this->agent_man_no;
        $this->agent->endpoint = $this->agent_endpoint;
        $this->agent->state = $this->agent_state;

        $this->agent->set_number = $this->agent_set_number;
        $this->agent->user_id = $this->agent_user_id;
        $this->agent->status = $this->agent_status;
        $this->agent->save();


        // Flash success message
        session()->flash('success', 'Session updated successfully!');

        // Emit event to close the modal
        $this->emit('closeModal');
    }

    public function updatedAgentManNo()
    {

        $user = User::where('man_no', $this->agent_man_no)->first();
        if ($user != null) {
            $this->agent_name = $user->name;
            $this->agent_user_id = $user->id;
        }
    }

    public function filterRecordings()
    {

        $rec = LiveRecordings::where('dst', $this->agent_endpoint);

        if (isset($this->to) && empty($this->from)) {

            $rec->whereDate('created_at', $this->to);
            $this->rec_title = "Recordings for " . $this->to;
        } elseif (isset($this->from) && empty($this->to)) {
            $rec->whereDate('created_at', $this->from);
            $this->rec_title = "Recordings for " . $this->from;
        } elseif (isset($this->to) && isset($this->from)) {
            $rec->whereBetween('created_at', [$this->from, $this->to]);
            $this->rec_title = "Recordings between " . $this->from . ' and ' . $this->to;
        } else {
            //  dd($this->agent_endpoint);
            $rec->whereDate('created_at', Carbon::today());
        }


        if ($this->search) {
            $search = strtolower($this->search);
            $rec->where(function ($rec) use ($search) {
                $rec->whereRaw('LOWER(phone_number) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(clid) like ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(dst) like ?', ['%' . $search . '%'])
                    ->orWhereHas('agent', function ($rec) use ($search) {
                        $rec->whereRaw('LOWER(name) like ?', ['%' . $search . '%']);
                    });
            });
        }




        $this->totalRecords = $rec->count();
        $rec = $rec->paginate(5);


        return $rec;
    }

    public function getTranasactionCodes($id)
    {
        $this->recording = LiveRecordings::findOrFail($id);
    }

    public function editTCode()
    {
        LiveRecordings::where('id', $this->recording->id)
            ->update(['transaction_code' => $this->t_code]);
        $this->t_code = null;
        session()->flash('success', 'Transaction code updated successfully!');
    }
}

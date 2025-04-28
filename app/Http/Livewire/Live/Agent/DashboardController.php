<?php

namespace App\Http\Livewire\Live\Agent;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Live\CCAgent;
use App\Models\Live\CallSession;
use App\Models\Live\CallSessionToAgent;
use App\Models\CDR\CallDetailsRecordModel;
use App\Models\Customer;
use App\Models\Live\Recordings;
use App\Models\User;
use App\Models\KnowledgeBase;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DashboardController extends Component
{
    public $agent_num, $set_number, $user, $agent, $agent_status;
    public $meter_number, $service_no, $complaint_no, $meter_serial_no;
    public $complaint_status_desc, $landmark, $meter_no;

    public $sessions, $selectedSession, $currentSession, $server;
    public $customer_details = [];
    public $complaints = [];
    public $searchCustomer;

    public $searchQuery = '';
    public $searchResults = [];
    public $selectedTopic;
    public $selectedCustomer;
    public $show_modal = false;
    public $search_term;
    public $searchCustomers;
    public $loadCustomerDetails;
    public $is_searching = false;
    protected $rules = [
        'search_term' => 'required|string|min:1|max:15',
    ];

    public function mount($id)
    {
        $this->user = User::findOrFail($id);
        $this->sessions = CallSession::all();
        $this->selectedSession = session('current_session_id', '');

        if ($this->selectedSession) {
            $this->currentSession = CallSession::find($this->selectedSession);
        }
    }

    public function updatedSearchQuery($value)
    {
        $value = trim($value);

        if (strlen($value) >= 2) {
            $this->searchResults = KnowledgeBase::query()
                ->where(function ($query) use ($value) {
                    $query->where('topic', 'like', "%$value%")
                        ->orWhere('description', 'like', "%$value%");
                })
                ->select('id', 'topic', 'description')
                ->limit(5)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'topic' => $item->topic,
                        'description' => Str::limit(strip_tags($item->description), 100),
                    ];
                })
                ->toArray();
        } else {
            $this->reset(['searchResults', 'selectedTopic']);
        }
    }

    public function selectTopic($topicId)
    {
        $this->selectedTopic = KnowledgeBase::find($topicId);
        $this->searchQuery = $this->selectedTopic->topic ?? '';
        $this->searchResults = [];
    }

    public function changeSession()
    {
        $this->currentSession = CallSession::find($this->selectedSession);
        session(['current_session_id' => $this->selectedSession]);
        $this->dispatchBrowserEvent('hide-modal');

        session()->flash('message', 'Session changed successfully.');
    }

    public function updatedSearchTerm($value)
    {
        // Only search if term has at least 3 characters
        if (strlen(trim($value)) >= 3) {
            $this->is_searching = true;
            $this->searchCustomers();
        } else {
            $this->reset(['customer_details', 'show_modal']);
        }
    }

    public function searchCustomers()
    {
        Log::info("errorMessage");
        $this->validate();
//       ($customer_details = Customer::where('service_no', $this->service_no)->orWhere('meter_serial_no', $this->service_no)->first();
//        dd(Customer::where('meter_no', '=', '04281634057')->get());
        $searchTerm = trim($this->search_term);
        $upperSearchTerm = strtoupper($searchTerm);

        $this->customer_details = Customer::where(function($query) use ($searchTerm, $upperSearchTerm) {
            $query->where('meter_serial_no', 'like', '%'.$upperSearchTerm.'%')
                ->orWhere('service_no', 'like', '%'.$searchTerm.'%')
                ->orWhere('complaint_no', 'like', '%'.$searchTerm.'%')
                ->orWhere('customer_name', 'like', '%'.$searchTerm.'%');
        })
            ->orderBy('complaint_status_desc', 'asc')
//            ->orderBy('created_at', 'desc')
            ->take(50) // Limit results for performance
            ->get();

        $this->show_modal = count($this->customer_details) > 0;
        $this->is_searching = false;
    }

    public function closeModal()
    {
       $this->reset(['show_modal', 'search_term', 'customer_details']);
    }

    public function login()
    {
        $this->agent->update([
            'state' => config('constants.agent_state.LOGGED_IN'),
            'status' => config('constants.agent_status.IDLE'),
        ]);
    }

    public function status($status)
    {
        $this->agent->update([
            'status' => $status,
        ]);
    }

    public function logout()
    {
        $this->agent->update([
            'state' => config('constants.agent_state.LOGGED_OUT'),
            'status' => config('constants.agent_status.LOGGED_OUT'),
        ]);
    }

    public function saveSession()
    {
        $this->changeSession();
        session()->flash('message', 'Session saved successfully.');
    }

    public function showModal()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function clearSession()
    {
        Session::put('current_session_id', null);
        $this->currentSession = null;
    }

    public function answeredCalls()
    {
        return Auth::user()->myCallRecordings;
    }

    public function render()
    {
        $this->agent = $this->user->myAgentDetails;
        $this->agent_num = $this->agent->endpoint ?? '';

        $api_server = config('app.API_SERVER_ENDPOINT');
        $ws_server = config('app.WS_SERVER_ENDPOINT');

        $callsQuery = Recordings::where('agent_number', 'like', "%{$this->agent_num}%");

        return view('livewire.live.agent.dashboard-controller', [
            'agent' => $this->agent,
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'totalCalls' => $callsQuery->count(),
            'answeredCalls' => $callsQuery->count(), // You can later refine this if you separate answered vs missed
            'missedCalls' => $callsQuery->count(),   // Likewise refine later
            'averageCallTime' => gmdate('H:i:s', $callsQuery->avg('duration_number') ?: 0),
            'lastFiveCalls' => $callsQuery->latest('agent_number')->take(5)->get(),
            'customer_details' => $this->customer_details,
        ]);
    }
}

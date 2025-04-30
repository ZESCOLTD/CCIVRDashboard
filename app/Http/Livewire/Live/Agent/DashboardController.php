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

use App\Models\Live\DialEventLog;

class DashboardController extends Component
{
    public $agent_num, $set_number, $user, $agent, $agent_status;
    public $meter_number, $service_no, $complaint_no, $meter_serial_no;
    public $complaint_status_desc, $landmark, $meter_no;

    public $sessions, $selectedSession, $currentSession, $server;
    public $customer_details = [];
    public $complaints = [];
    public $searchCustomer;


    //    AGENT TIME OUT  LOGIC
    public $onBreak = false;

    public $breakStartTime = null;
    public $totalBreakMinutesUsed = 0;
    public $breakDuration = '00:00:00';
    public $breakLimitReached = false;
    public $breakMinutes = 0;


    //    public $breakDuration = null;

    //AGENT TIME OUT END LOGIC

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
        $this->agent = User::findOrFail($id);
        $this->user = $this->agent;

        $this->sessions = CallSession::all();
        $this->selectedSession = session('current_session_id', '');

        // Check if the agent is already on break
        if ($this->agent && $this->agent->status === config('constants.agent_status.ON_BREAK')) {
            $this->onBreak = true;
            $this->breakStartTime = $this->agent->updated_at;

            // Calculate the initial duration on load
            dd($seconds = now()->diffInSeconds($this->breakStartTime));
            $this->breakDuration = gmdate('H:i:s', $seconds);

            $this->checkBreakLimit($seconds);
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

        $this->customer_details = Customer::where(function ($query) use ($searchTerm, $upperSearchTerm) {
            $query->where('meter_serial_no', 'like', '%' . $upperSearchTerm . '%')
                ->orWhere('service_no', 'like', '%' . $searchTerm . '%')
                ->orWhere('complaint_no', 'like', '%' . $searchTerm . '%')
                ->orWhere('customer_name', 'like', '%' . $searchTerm . '%');
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

        $this->agent->refresh();
        $this->emit('refreshComponent');
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

        $calls = DialEventLog::orderBy('event_timestamp')
            ->get()
            ->groupBy(function ($event) {
                return $event->dialstring . '_' . $event->peer_id;
            });


        $callResults = $calls->map(function ($events, $key) {
            $sorted = $events->sortBy('event_timestamp');

            $lastWithStatus = $sorted->reverse()->first(fn($e) => !empty($e->dialstatus));

            if (!$lastWithStatus) return null;

            return [
                'dialstring' => $lastWithStatus->dialstring,
                'caller_number' => $lastWithStatus->caller_number,
                'status' => $lastWithStatus->dialstatus,
                'timestamp' => $lastWithStatus->event_timestamp,
            ];
        })->filter(); // remove nulls


        // dd($callResults);

        $answered = count($callResults->where('status', 'ANSWER')
        ->where('dialstring', $this->agent->endpoint));
        $missed = count($callResults->where('status', 'NOANSWER')
        ->where('dialstring', $this->agent->endpoint));

        // dd($answered, $missed);

        return view('livewire.live.agent.dashboard-controller', [
            'agent' => $this->agent,
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'totalCalls' => $answered+$missed,
            'answeredCalls' => $answered, // You can later refine this if you separate answered vs missed
            'missedCalls' => $missed,   // Likewise refine later
            'averageCallTime' => gmdate('H:i:s', $callsQuery->avg('duration_number') ?: 0),
            'lastFiveCalls' => $callsQuery->latest('agent_number')->take(5)->get(),
            'customer_details' => $this->customer_details,
        ]);
    }

    protected $listeners = ['refreshComponent' => '$refresh'];


    //    Agent Time Out Logic start
    public function toggleBreak()
    {
        $limit = $this->getCurrentShiftLimit();

        if ($this->agent->status !== config('constants.agent_status.ON_BREAK')) {
            // Check if break limit has been reached
            if ($this->totalBreakMinutesUsed >= $limit) {
                $this->breakLimitReached = true;
                return;
            }

            // Start break
            $this->agent->update([
                'status' => config('constants.agent_status.ON_BREAK'),
            ]);
            $this->breakStartTime = now();
            $this->breakLimitReached = false;
        } else {
            // Resume from break
            $this->agent->update([
                'status' => config('constants.agent_status.IDLE'),
            ]);

            // Add break time to total
            if ($this->breakStartTime) {
                $elapsed = now()->diffInMinutes($this->breakStartTime);
                $this->totalBreakMinutesUsed += $elapsed;
            }

            $this->breakStartTime = null;
            $this->breakDuration = '00:00:00';

            // Check if break limit has now been reached
            if ($this->totalBreakMinutesUsed >= $limit) {
                $this->breakLimitReached = true;
            }
        }
    }

    public function calculateBreakDuration()
    {
        if ($this->breakStartTime) {
            $this->breakDuration = now()->diff($this->breakStartTime)->format('%H:%I:%S');
        }
    }

    public function updated()
    {
        $this->calculateBreakDuration();
    }
    //    Agent Time Out Logic start

    //   Shift Logic time management start
    private function getCurrentShiftLimit(): int
    {
        $now = now();

        if ($now->between($now->copy()->setTime(7, 0), $now->copy()->setTime(14, 0))) {
            return 40; // First shift
        }

        if ($now->between($now->copy()->setTime(14, 0), $now->copy()->setTime(21, 0))) {
            return 40; // Second shift
        }

        // Night shift: 21:00 to 07:00 (next day)
        return 60;
    }

    //   Shift Logic time management start

    public function getBreakDurationProperty()
    {
        if ($this->agent->status === config('constants.agent_status.ON_BREAK') && $this->breakStartTime) {
            $seconds = now()->diffInSeconds($this->breakStartTime);
            $this->checkBreakLimit($seconds); // Optional to auto-lock

            return gmdate('H:i:s', $seconds);
        }

        return '00:00:00';
    }

    public function updateBreakTimer()
    {
        if ($this->onBreak && $this->breakStartTime) {
            $seconds = now()->diffInSeconds(\Carbon\Carbon::parse($this->breakStartTime));
            $this->breakDuration = gmdate('H:i:s', $seconds);
            $this->breakMinutes = floor($seconds / 60);
            $this->checkBreakLimit($seconds);
        }
    }
}

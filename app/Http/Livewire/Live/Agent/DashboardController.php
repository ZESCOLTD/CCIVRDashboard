<?php

namespace App\Http\Livewire\Live\Agent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Live\CCAgent;
use App\Models\Live\CallSession;
use App\Models\Live\CallSessionToAgent;
use App\Models\CDR\CallDetailsRecordModel;
use App\Models\Customer;
use App\Models\Live\Recordings;
use App\Models\User;
use App\Models\Technical;
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
    public $complaints = [];
    public $searchCustomer;
    public $popularTopics;

    public $popularTopic;


//    AGENT TIME OUT  LOGIC
    public $onBreak = false;

    public $breakStartTime = null;
    public $totalBreakMinutesUsed = 0;
    public $breakDuration = '00:00:00';
    public $breakLimitReached = false;
    public $breakMinutes = 0;

//AGENT TIME OUT END LOGIC

//Logic for customer search start
    public $search_term;
    public $customer_details = [];
    public $show_modal = false;
    public $is_searching = false;
//Logic for customer search end

    public $searchQuery = '';
    public $searchResults = [];
    public $selectedTopic;
    public $selectedCustomer;


    public $loadCustomerDetails;
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
            $this->searchResults = Technical::query()
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
        $this->selectedTopic = Technical::find($topicId);
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


//    public function updatedSearchTerm($value)
//    {
//        $value = trim($value);
//
//        if (strlen($value) > 0) {
//            $this->searchCustomers($value);
//        } else {
//            $this->reset(['customer_details', 'show_modal']);
//        }
//    }

    public function searchCustomers()
    {
        ini_set("memory_limit", -1);
        set_time_limit(300);

        $searchTerm = strtoupper(trim($this->search_term));
        $results = collect();

        // Step 1: Try by meter_serial_no
        $results = Customer::where('meter_serial_no', $searchTerm)->get();

        // Step 2: Try by service_no if empty
        if ($results->isEmpty()) {
            $results = Customer::where('service_no', $searchTerm)->get();
        }

        // Step 3: Try by complaint_no if still empty
        if ($results->isEmpty()) {
            $results = Customer::where('complaint_no', $searchTerm)->get();
        }

        // Step 4: Filter based on complaint status
        $statuses = $results->pluck('complaint_status_desc')->unique();

        if ($statuses->count() === 1 && $statuses->first() === 'RESOLVED') {
            $results = $results->take(2);
        } elseif ($statuses->contains('PENDING')) {
            // keep all (no limit)
        } elseif ($statuses->contains('ASSOCIATED TO INCIDENCE')) {
            $results = $results->take(3);
        } else {
            $results = $results->take(5);
        }

        // Step 5: Store and emit
        session(['customer_details' => $results]);
        $this->customer_details = $results;
        $this->emit('showCustomerModal');
    }





//    public function closeModal()
//    {
//        $this->reset(['show_modal', 'search_term', 'customer_details']);
//    }




    public function login()
    {
        $this->agent->update([
            'state' => config('constants.agent_state.LOGGED_IN'),
            'status' => config('constants.agent_status.IDLE'),
        ]);
        $this->emit('agentLogin');

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
        $this->emit('agentLogout');
    }

    public function saveSession()
    {
        $this->changeSession();
        $this->emit('shiftedSelected');
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

        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();


        $this->agent = $this->user->myAgentDetails;
        $this->agent_num = $this->agent->endpoint ?? '';
        $this->selectedSession = session('current_session_id', '');
        $this->customer_details = session('customer_details', collect());


        $api_server = config('app.API_SERVER_ENDPOINT');
        $ws_server = config('app.WS_SERVER_ENDPOINT');

        $popularTopics = Technical::orderByDesc('views')
            ->take(5)
            ->get(['id', 'topic']);

        $callsQuery = Recordings::where('agent_number', 'like', "%{$this->agent_num}%");

        $today = now()->toDateString(); // or Carbon::today()

        $callsQuery = Recordings::where('agent_number', 'like', "%{$this->agent_num}%")
        ->whereDate('created_at', $today);

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




        return view('livewire.live.agent.dashboard-controller', [
            'agent' => $this->agent,
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'totalCalls' => $answered+$missed,
            'answeredCalls' => $answered, // You can later refine this if you separate answered vs missed
            'missedCalls' => $missed, // Likewise refine later
            'averageCallTime' => gmdate('H:i:s', $callsQuery->avg('duration_number') ?: 0),
            'lastFiveCalls' => $callsQuery->latest('agent_number')->take(5)->get(),
            'customer_details' => $this->customer_details,
            'popularTopics' => $popularTopics,

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

    public function clearCustomerDetailsSession()
    {
        session()->forget('customer_details');
        $this->customer_details = collect();
    }


}

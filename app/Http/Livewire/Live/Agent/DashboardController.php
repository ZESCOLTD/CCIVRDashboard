<?php

namespace App\Http\Livewire\Live\Agent;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Live\CCAgent;
use App\Models\Live\CallSession;
use App\Models\Live\CallSessionToAgent;

use App\Models\Live\TransactionCode;
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
use App\Models\Live\AgentBreak; // ✅ Import the model
use Carbon\Carbon;

class DashboardController extends Component
{

    public $agent_num, $set_number, $user;
    public $agent;
    public $agent_status;

    public $sessions;
    public $selectedSession;
    public $currentSession;
    public $server;
    public $customer_details;
    public $meter_number;

    public $searchQuery = '';
    public $searchResults = [];
    public $selectedTopic;
    public $selectedCustomer;


    //    AGENT TIME OUT  LOGIC
    public $onBreak = false;

    public $breakStartTime = null;
    public $totalBreakMinutesUsed = 0;
    public $breakDuration = '00:00:00';
    public $breakLimitReached = false;
    public $breakMinutes = 0;

    public $totalBreakDuration;
    public $t_code;
    public $transactionCodes;
    public $recordFilename;


    protected $listeners = ['refresh' => '$refresh', 'filename' => 'filename','showCustomerModal'];

    // Logic for customer search start
    public $search_term;
    public $show_modal = false; // You might not need this if relying on the modal's ID
    public $is_searching = false; // You might not need this, can use wire:loading state
    // Logic for customer search end

    protected $rules = [
        'search_term' => 'required|string|min:1|max:15',
    ];

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->transactionCodes = TransactionCode::all();

        $user = $this->user;
        $this->agent = $user->myAgentDetails;
        $this->calculateTotalBreakDurationForToday();
        // Load all available sessions
        $this->sessions = CallSession::all();

        // Set selectedSession from application or browser session, if available
        $this->selectedSession = session('current_session_id', '');

        // Check if selectedSession is empty or null
        // if (empty($this->selectedSession)) {
        //     $this->dispatchBrowserEvent('show-session-modal'); // Emit event to show the modal
        // }

        // Load the current session details if there's a selected session
        if ($this->selectedSession) {
            $this->currentSession = CallSession::find($this->selectedSession);
        }
        // dd($this->currentSession);
    }


    public function selectTopic($topicId)
    {
        $this->selectedTopic = Technical::find($topicId); // Use Technical model
        $this->searchQuery = $this->selectedTopic->topic ?? ''; // Use optional chaining
        $this->searchResults = [];
    }

    //Search funtionality



    public function filename($filename)
    {

        $this->recordFilename = $filename;
    }


    public function changeSession()
    {
        $this->currentSession = CallSession::find($this->selectedSession);
        // Save the selected session ID to the session
        session(['current_session_id' => $this->selectedSession]);
        // $this->dispatchBrowserEvent('hide-modal');

        // Validate incoming request data
        // $validatedData = $request->validate([
        //     'agent_id' => 'required|integer',
        //     'call_session_id' => 'required|string',
        //     'status' => 'required|string',
        //     'time_from' => 'required|date',
        //     'time_to' => 'nullable|date',
        //     'session_name' => 'required|string',
        //     'username' => 'required|string',
        // ]);

        // Optionally, you can perform any additional logic or database updates here
        // Find an existing record by call_session_id
        $callSession = CallSessionToAgent::where('call_session_id', $this->currentSession->id)->first();

        // if ($callSession) {
        //     // Update the existing record
        //     $callSession->update($validatedData);
        //     return response()->json(['message' => 'Call session updated successfully.', 'data' => $callSession], 200);
        // } else {

        //     $user = Auth::user();
        //     // Create a new record
        //     $callSession = CallSessionToAgent::create(
        //         [

        //         'call_session_id' => $this->currentSession->id,
        //         'status' => '1',
        //         'time_from' => $this->currentSession->time_from,
        //         'time_to' => $this->currentSession->time_to,
        //         'session_name' => $this->currentSession->name,
        //         'agent_id' => $user->id,
        //         'agent_number' =>  $this->agent_num ,
        //         'set_number' =>  $this->set_number ,
        //         'username' => $user->name
        //         ],
        //         [

        //             'call_session_id' => $this->currentSession->id,
        //             'status' => '1',
        //             'time_from' => $this->currentSession->time_from,
        //             'time_to' => $this->currentSession->time_to,
        //             'session_name' => $this->currentSession->name,
        //             'agent_id' => $user->id,
        //             'agent_number' =>  $this->agent_num ,
        //             'set_number' =>  $this->set_number ,
        //             'username' => $user->name
        //         ]

        // );
        // }
        // $this->dispatchBrowserEvent('closeSessionModal');
        // Set success message
        session()->flash('message', 'Session saved successfully.');
    }

    public function render()
    {
        // dd($user->myAgentDetails);
        $this->agent_num = $this->agent !=null? $this->agent->endpoint:null;

        if($this->agent == null) {
            return view('livewire.live.agent.dashboard-null-endpoint',
            //  [
            //     'agent' => "Please Ensure you are assigned a valid agent number",
            //     'api_server' => null,
            //     'ws_server' => null,
            //     'totalCalls' => 0,
            //     'answeredCalls' => 0,
            //     'missedCalls' => 0,
            //     'averageCallTime' => 0,
            //     'lastFiveCalls' => [],
            //     'customer_details' => $this->customer_details,
            // ]
        );
        }
        $api_server = config("app.API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");


        // $totalCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->count();
        // $answeredCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num)->count();
        // $missedCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->count();
        // $averageCallTime = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->avg('duration_number');

        // // Fetching the last five calls
        // $lastFiveCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->latest('agent_number')->take(5)->get();


        $today = now()->toDateString(); // or Carbon::today()

        $callsQuery = Recordings::where('agent_number', 'like', "%{$this->agent_num}%")
            ->whereDate('created_at', $today);

        $calls = DialEventLog::orderBy('event_timestamp')
            ->whereDate('created_at', $today)
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


        $records = $callsQuery->get();

        $totalDurationInSeconds = $records->sum('duration_in_seconds');
        $recordCount = $records->count();

        $averageDurationFormatted = null;

        if ($recordCount > 0) {
            $averageDurationInSeconds = $totalDurationInSeconds / $recordCount;

            // You can then format this average duration into a human-readable format
            $minutes = floor($averageDurationInSeconds / 60);
            $seconds = round($averageDurationInSeconds % 60); // Round to the nearest second

            if ($seconds == 0) {
                $averageDurationFormatted = $seconds . ' min';
            } else {
                $averageDurationFormatted = $minutes . ':' . $seconds;
            }

            // $averageDurationFormatted will hold the average call duration in a readable format

        } else {
            // Handle the case where there are no records
            $averageDurationFormatted = "No call records found.";
        }

        return view('livewire.live.agent.dashboard-controller', [
            'agent' => $this->agent,
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'totalCalls' => $answered + $missed,
            'answeredCalls' => $answered, // You can later refine this if you separate answered vs missed
            'missedCalls' => $missed,   // Likewise refine later
            'averageCallTime' => $averageDurationFormatted,
            'lastFiveCalls' => $callsQuery->latest('agent_number')->take(5)->get(),
            'customer_details' => $this->customer_details,
        ]);
    }


    public function searchCustomers()
    {
        $this->validateOnly('search_term');
        $this->is_searching = true;
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

        // Step 4: Filter based on complaint status (same logic as DashboardController)
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
        $this->customer_details = $results;
        // dd($this->customer_details);
        $this->dispatchBrowserEvent('showCustomerModal'); // Emit the event to show the modal
        $this->is_searching = false;
    }

    public function clearCustomerDetailsSession()
    {
        $this->customer_details = []; // Clear the array
        $this->reset('search_term');
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


    public function login()
    {
        $now = now()->toTimeString();
        $today = now()->toDateString();

        // Find a CallSession that is currently active based on the time
        $activeSession = CallSession::whereTime('time_from', '<=', $now)
            ->whereTime('time_to', '>=', $now)
            ->first();

        if (!$activeSession) {
            session()->flash('error', 'No active call session found for the current time.');
            return;
        }

        $this->selectedSession = $activeSession->id;
        $this->currentSession = $activeSession;
        session(['current_session_id' => $this->selectedSession]);


        $server = config("app.API_SERVER_ENDPOINT");

        try {
            $response = Http::get($server . '/online/' . $this->agent_num);
            $data = $response->json();

            if ($data['status'] === true) {
                $this->agent->state = config('constants.agent_state.LOGGED_IN');
                $this->agent->status = config('constants.agent_status.IDLE');
                $this->agent->save();

                // Check if the agent has logged into this session before
                $existingSessionAgent = CallSessionToAgent::where('agent_id', $this->user->id)
                    ->where('call_session_id', $this->currentSession->id)
                    ->first();

                if (!$existingSessionAgent) {
                    // If it's the first time, reset the break time
                    $this->totalBreakDuration = '00:00:00';
                }

                // Create or update record in the CallSessionToAgent table
                CallSessionToAgent::updateOrCreate(
                    [
                        'call_session_id' => $this->currentSession->id,
                        'agent_id' => $this->user->id,
                    ],
                    [
                        'time_from' => now(), // Log the actual login time
                        'session_name' => $this->currentSession->name,
                        'agent_number' => $this->agent_num,
                        'username' => $this->user->name,
                        'status' => 1, // Or any default status you need
                    ]
                );

                // Refresh local data
                $this->agent = $this->agent->fresh();
                $this->calculateTotalBreakDurationForToday(); // Recalculate break duration after login

                session()->flash('message', 'Successfully logged in to session: ' . $this->currentSession->name );
                // session()->flash('message', 'Successfully logged in to session: ' . $this->currentSession->name . ' (' . $data['endpoint'] . ')');
                $this->emitSelf('refresh'); // Optional, if other components are listening
            } else {
                session()->flash('error', 'Agent ' . $data['endpoint'] . ' is not online.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    // public function editTCode()
    // {

    //     // dd($this->t_code);
    //     Recordings::where('file_name', $this->recordFilename)
    //         ->update(['transaction_code' => $this->t_code]);
    //     $this->t_code = null;
    //     session()->flash('success', 'Transaction code updated successfully!');
    //     // dd($this->recordFilename);

    // }

    public function editTCode()
    {
        // dd($this->t_code);
        $updated = Recordings::where('file_name', $this->recordFilename)
            ->update(['transaction_code' => $this->t_code]);

        if ($updated) {
            $this->t_code = null; // Clear the selected value
            session()->flash('success', 'Transaction code updated successfully!');
            $this->emit('refresh');
            $this->dispatchBrowserEvent('closeModal');

        } else {
            session()->flash('error', 'Failed to update transaction code.');
            // Optionally, you could dispatch an event to show an error message in the modal
            $this->dispatchBrowserEvent('closeModal');
        }
        // dd($this->recordFilename);
    }
    public function break()
    {
        if (!$this->agent) return;

        $this->agent->status = config('constants.agent_status.ON_BREAK');
        $this->agent->save();

        // Start new break
        AgentBreak::create([
            'agent_id' => $this->agent->id,
            'started_at' => now(),
        ]);

        $this->agent = $this->agent->fresh();
    }

    public function resume()
    {
        if (!$this->agent) return;

        $this->agent->status = config('constants.agent_status.IDLE');
        $this->agent->save();

        // End the latest break
        AgentBreak::where('agent_id', $this->agent->id)
            ->whereNull('ended_at')
            ->latest()
            ->update(['ended_at' => now()]);

        $this->agent = $this->agent->fresh();
    }
    public function status($status)
    {
        if (!$this->agent) {
            return;
        }

        if ($status === 'ON_BREAK') {
            // Toggle between ON_BREAK and IDLE
            $this->agent->status = $this->agent->status === 'ON_BREAK'
                ? config('constants.agent_status.IDLE')
                : config('constants.agent_status.ON_BREAK');
        } else {
            // Set any other status directly if needed
            $this->agent->status = $status;
        }

        $this->agent->save();
        $this->agent = $this->agent->fresh();
    }
    public function logout()
    {
        $this->resume();
        $this->agent->state =  config('constants.agent_state.LOGGED_OUT');
        $this->agent->status =  config('constants.agent_status.LOGGED_OUT');
        $this->agent->save();

        $this->agent->refresh();
        $this->clearSession();
        $this->emitSelf('refresh');
    }


    public function withdraw()
    {
        $this->agent->state =  config('constants.agent_state.LOGGED_IN');
        $this->agent->status =  config('constants.agent_status.WITHDRAWN');
        $this->agent->save();

        $this->agent->refresh();
        $this->emitSelf('refresh');
    }




    public function saveSession()
    {
        self::changeSession();
        $this->dispatchBrowserEvent('closeSessionModal');
        // Set success message
        session()->flash('message', 'Session saved successfully.');
        $this->emitSelf('refresh');
        $this->login();
    }


    public function showModal()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function clearSession()
    {
        Session::put('current_session_id', null);
        $this->currentSession = null;
        $this->selectedSession = null;
    }

    public function answeredCalls()
    {
        Auth::user()->myCallRecordings;
    }


    public function updateBreakTimer()
    {

        if (!$this->agent) return;

        $totalSeconds = 0;


        $breaks = AgentBreak::where('agent_id', $this->agent->id)->get();

        foreach ($breaks as $break) {
            $start = Carbon::parse($break->started_at);
            $end = $break->ended_at ? Carbon::parse($break->ended_at) : now();
            $totalSeconds += $end->diffInSeconds($start);
        }

        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        $this->totalBreakDuration = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        $this->breakLimitReached = $totalSeconds > 40 * 60;
    }

    public function calculateTotalBreakDuration()
    {

        if($this->agent == null) {
            $this->totalBreakDuration = '00:00:00';
            return;
        }


        $totalSeconds = AgentBreak::where('agent_id', $this->agent->id)
            ->get()
            ->reduce(function ($carry, $break) {
                $end = $break->ended_at ?? now(); // still on break if ended_at is null
                return $carry + $end->diffInSeconds($break->started_at);
            }, 0);

        $this->totalBreakDuration = gmdate('H:i:s', $totalSeconds);
        // dd($this->totalBreakDuration);
    }
    // public function calculateTotalBreakDuration()
    // {
    //     if (!$this->agent || !$this->currentSession) {
    //         $this->totalBreakDuration = '00:00:00';
    //         // dd("No agent or session found");
    //         return;
    //     }

    //     // Get the last login time for the current agent in the current session
    //     $lastLoginTime = CallSessionToAgent::where('agent_id', $this->agent->id)
    //         ->where('call_session_id', $this->currentSession->id)
    //         ->latest('created_at')
    //         ->value('created_at');

    //     if (!$lastLoginTime) {
    //         $this->totalBreakDuration = '00:00:00';
    //         // dd($this->totalBreakDuration);
    //         return;
    //     }

    //     $totalSeconds = AgentBreak::where('agent_id', $this->agent->id)
    //         ->where('started_at', '>=', $lastLoginTime) // Only consider breaks after the last login
    //         ->get()
    //         ->reduce(function ($carry, $break) {
    //             $end = $break->ended_at ?? now();
    //             return $carry + $end->diffInSeconds($break->started_at);
    //         }, 0);

    //     $this->totalBreakDuration = gmdate('H:i:s', $totalSeconds);
    //     // dd($this->totalBreakDuration);
    // }

    public function calculateTotalBreakDurationForToday()
{
    if (!$this->agent) {
        $this->totalBreakDuration = '00:00:00';
        return;
    }

    $todayStart = now()->startOfDay();
    $todayEnd = now()->endOfDay();

    $totalSeconds = AgentBreak::where('agent_id', $this->agent->id)
        ->where('started_at', '>=', $todayStart)
        ->where('started_at', '<=', $todayEnd)
        ->get()
        ->reduce(function ($carry, $break) {
            $end = $break->ended_at ?? now(); // still on break if ended_at is null
            return $carry + $end->diffInSeconds($break->started_at);
        }, 0);

    $this->totalBreakDuration = gmdate('H:i:s', $totalSeconds);
    // dd($this->totalBreakDuration);
}

}

<?php


namespace App\Http\Livewire\Live;

use Livewire\Component;
use App\Models\Live\CCAgent;
use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Live\CallSessionToAgent;
use Illuminate\Support\Facades\Session;
use App\Models\CDR\CallDetailsRecordModel;
use App\Http\Livewire\Reports\CallDetailRecords;
use App\Models\Customer;
use App\Models\Live\Recordings;
use App\Models\User;
use App\Models\KnowledgeBase;
use Illuminate\Support\Str;
use App\Models\Live\DialEventLog;

use App\Models\Live\TransactionCode;

use App\Models\Live\AgentBreak; // ✅ Import the model
use Carbon\Carbon;


class AgentComponent extends Component
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


    protected $listeners = ['refresh' => '$refresh'];

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

        $this->transactionCodes = TransactionCode::all();

        $user = $this->user;
        $this->agent = $user->myAgentDetails;
        $this->calculateTotalBreakDuration();
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

    //Search funtionality
    public function updatedSearchQuery($value)
    {
        $value = trim($value);

        if (strlen($value) >= 2) {
            $this->searchResults = KnowledgeBase::query()
                ->where(function ($query) use ($value) {
                    $query->where('topic', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%');
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
            $this->searchResults = [];
            $this->selectedTopic = null;
        }
    }

    public function selectTopic($topicId)
    {
        $this->selectedTopic = KnowledgeBase::find($topicId);
        $this->searchQuery = $this->selectedTopic->topic;
        $this->searchResults = [];
    }

    //Search funtionality



    //    public function selectTopic($topicId)
    //    {
    //        $this->selectedTopic = KnowledgeBase::find($topicId);
    //        $this->searchQuery = $this->selectedTopic->topic;
    //        $this->searchResults = [];
    //    }

    //    Search Result for Knowledge base

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
        $this->dispatchBrowserEvent('closeSessionModal');
        // Set success message
        session()->flash('message', 'Session saved successfully.');
    }

    public function render()
    {
        // dd($user->myAgentDetails);
        $this->agent_num = $this->agent->endpoint;
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

        return view('livewire.live.agent-component', [
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

    public function login()
    {
        if (empty($this->selectedSession) || $this->selectedSession == null) {
            $this->dispatchBrowserEvent('show-session-modal');
            return;
        }

        $server = config("app.API_SERVER_ENDPOINT");

        try {
            $response = Http::get($server . '/online/' . $this->agent_num);
            $data = $response->json();

            if ($data['status'] === true) {
                $this->agent->state = config('constants.agent_state.LOGGED_IN');
                $this->agent->status = config('constants.agent_status.IDLE');
                $this->agent->save();

                // Refresh local data
                $this->agent = $this->agent->fresh();
                $this->currentSession = CallSession::find($this->selectedSession);

                session()->flash('message', 'Successfully logged in: ' . $data['endpoint']);
                $this->emitSelf('refresh'); // Optional, if other components are listening
            } else {
                session()->flash('error', 'Agent ' . $data['endpoint'] . ' is not online.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function editTCode()
    {
        dd($this->t_code);

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

    $this->agent->status = config('constants.agent_status.LOGGED_IN');
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


        $totalSeconds = AgentBreak::where('agent_id', $this->agent->id)
            ->get()
            ->reduce(function ($carry, $break) {
                $end = $break->ended_at ?? now(); // still on break if ended_at is null
                return $carry + $end->diffInSeconds($break->started_at);
            }, 0);

        $this->totalBreakDuration = gmdate('H:i:s', $totalSeconds);
        // dd($this->totalBreakDuration);
    }
}

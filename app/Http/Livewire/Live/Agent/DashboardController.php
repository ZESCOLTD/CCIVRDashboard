<?php

namespace App\Http\Livewire\Live\Agent;

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


    protected $listeners = ['refresh' => '$refresh'];

    public function mount($id)
    {
        $this->user = User::findOrFail($id);

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
        $user = $this->user;
        $this->agent = $user->myAgentDetails;
        // dd($user->myAgentDetails);
        $this->agent_num = $this->agent->endpoint;
        $api_server = config("app.API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");


        $totalCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->count();
        $answeredCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->count();
        $missedCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->count();
        $averageCallTime = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->avg('duration_number');

        // Fetching the last five calls
        $lastFiveCalls = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')->latest('agent_number')->take(5)->get();


        return view('livewire.live.agent.dashboard-controller', [
            'agent' => $this->agent,
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'totalCalls' => $totalCalls,
            'answeredCalls' => $answeredCalls,
            'missedCalls' => $missedCalls,
            'averageCallTime' => gmdate('H:i:s', $averageCallTime),
            'lastFiveCalls' => $lastFiveCalls,
            'customer_details' => $this->customer_details
        ]);
    }

    public function login()
    {

        if (empty($this->selectedSession)) {
            $this->dispatchBrowserEvent('show-session-modal'); // Emit event to show the modal
            return;
        }

        $server = config("app.API_SERVER_ENDPOINT");

        try {
            $response = Http::get($server . '/online/' . $this->agent_num);

            $data = $response->json();

            if ($data['status'] === true) {
                // The agent is online
                $this->agent->state = config('constants.agent_state.LOGGED_IN');
                $this->agent->status = config('constants.agent_status.IDLE');
                $this->agent->save();

                $this->agent->refresh();

                session()->flash('message', 'Successfully logged in: ' . $data['endpoint']);

                $this->emitSelf('refresh');
            } else {
                // Agent is not online
                session()->flash('error', 'Agent ' . $data['endpoint'] . ' is not online.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function status($status)
    {
        $this->agent->status = $status;
        $agent_status = $status;
        $this->agent->save();
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
        Auth::user()->myCallRecordings;
    }
}

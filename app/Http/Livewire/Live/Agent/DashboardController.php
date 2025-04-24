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

    protected $listeners = ['refreshLastCall' => 'loadLastCall','refreshLastFileName' => 'loadLastFilename'];
    public $recordingFileName;
    public $filename;

    public function mount($id)
    {

        $this->user = User::findOrFail($id);

        // Load all available sessions
        $this->sessions = CallSession::all();

        // Set selectedSession from application or browser session, if available
        $this->selectedSession = session('current_session_id', '');

        // Load the current session details if there's a selected session
        if ($this->selectedSession) {
            $this->currentSession = CallSession::find($this->selectedSession);
        }

        // $this->server = config("constants.configs.API_SERVER_ENDPOINT");
    }

    public function loadLastCall()
    {
        $this->recordingFileName = Recordings::where('agent_number', 'LIKE', '%' . $this->agent_num . '%')
        ->where('file_name', '=', $this->filename)->get();
    }
    public function loadLastFilename($filename=null)
    {
        $this->filename = $filename;
        dd($this->filename);
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
        $this->dispatchBrowserEvent('hide-modal');

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

        // $this->customer_details = Customer::where('meter_no', '=', $meter_no)->get();
        //dd(Customer::where('meter_no', '=', 'Z01851393')->get());
         $query = Customer::query();
//        $query = Customer::select([
//            //'region',
//            //'zone',
//            'division',
//            'service_no',
//            'service_point',
//            //'csc',
//            //'tariff',
//            'itinerary_assigned',
//            //'declared_demand',
//            'premise_id',
//            'customer_name',
//            'meter_no',
//            'meter_serial_no',
//            'meter_make',
//            'meter_type_code',
//            'meter_status',
//            'phase_type',
//            'phase_type',
//            'voltage_type',
//            'meter_rating',
//            'meter_constant',
//            'meter_instal_date',
//            'town',
//            'meter_type',
//            'connection_type',
//            //'province',
//            //'township',
//            //'street',
//            //'address',
//            // 'home_phone',
//            // 'buss_phone',
//            // 'other_phone',
//        ]);

        if ($this->meter_number) {
            $meter_number = strtoupper($this->meter_number);
            $query->where(function ($query) use ($meter_number) {
                $query->where('meter_serial_no', '=', $meter_number);
            });

            $this->customer_details = $query->get();
        }

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

    public function customerDetails($meter_no)
    {
        // "region" => "KITWE REGION"
        // "zone" => "KITWE"
        // "division" => "COPPERBELT PROVINCE"
        // "service_no" => "3678784"
        // "service_point" => "3219680"
        // "csc" => "CSC - KITWE TOWN OFFICE"
        // "tariff" => "PREPAYMENT RESIDENTIAL TARIFF"
        // "itinerary_assigned" => "13032"
        // "declared_demand" => "15"
        // "premise_id" => "3283935"
        // "customer_name" => "TEMBO     ANDERSON"
        // "meter_no" => "Z01851393"
        // "meter_serial_no" => "07076828628"
        // "meter_make" => "LANDIS&GYR                                                                      "
        // "meter_type_code" => "10-SA123"
        // "meter_status" => "INSTALLED"
        // "phase_type" => "1- Phase"
        // "voltage_type" => "230-250V"
        // "meter_rating" => "20-80"
        // "meter_constant" => "1"
        // "meter_instal_date" => "2011-06-22 00:00:00"
        // "town" => "KITWE "
        // "meter_type" => "PREPAYMENT"
        // "connection_type" => "PREPAYMENT METER ( X1 )"
        // "province" => "COPPERBELT PROVINCE"
        // "township" => "NEW NDEKE"
        // "street" => "KAKOSHI"
        // "address" => "1940 B KAKOSHI ROAD , NEW NDEKE ."
        // "home_phone" => " "
        // "buss_phone" => " "
        // "other_phone" => " "

        $this->customer_details = Customer::where('meter_serial_no', '=', $meter_no)->get();
    }

    public function login()
    {
        $this->agent->state =  config('constants.agent_state.LOGGED_IN');
        $this->agent->status =  config('constants.agent_status.IDLE');
        $this->agent->save();
        $server = config("app.API_SERVER_ENDPOINT");
        // try {
        //     $response = Http::get($server . '?login=login&endpoint=' .  $this->agent_num);
        //     // Set success message
        //     session()->flash('message', 'Successfully logged in.');
        // } catch (\Exception $e) {
        //     // Set error message
        //     session()->flash('error', 'Error: ' . $e->getMessage());
        // }
    }

    public function status($status)
    {
        $this->agent->status = $status;
        $agent_status = $status;
        $this->agent->save();
        // try {
        //     $response = Http::get($this->server . '?status=' . $agent_status . '&endpoint=' .  $this->agent_num);
        //     // Set success message
        //     session()->flash('message', 'Connected successfully.');
        // } catch (\Exception $e) {
        //     // Set error message
        //     session()->flash('error', 'Failed to connect: ' . $e->getMessage());
        // }
    }
    public function logout()
    {
        $this->agent->state =  config('constants.agent_state.LOGGED_OUT');
        $this->agent->status =  config('constants.agent_status.LOGGED_OUT');
        $this->agent->save();

        $this->agent->refresh();
        // self::clearSession();

        // try {

        //     $response = Http::get($this->server . '?logout=logout&endpoint=' .  $this->agent_num);
        //     // Save the selected session ID to the session

        //     // Set success message
        //     session()->flash('message', 'PBX credentials successfully updated.');
        // } catch (\Exception $e) {
        //     // Set error message
        //     session()->flash('error', 'Failed to update PBX credentials: ' . $e->getMessage());
        // }
    }



    public function saveSession()
    {
        self::changeSession();
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

// class CallManager extends \Livewire\Component
// {
//     public $sessions;
//     public $selectedSession;
//     public $currentSession;

//     public function mount()
//     {
//         // Load all available sessions
//         $this->sessions = \App\Models\Session::all();

//         // Set selectedSession from application or browser session, if available
//         $this->selectedSession = session('current_session_id', '');

//         // Load the current session details if there's a selected session
//         if ($this->selectedSession) {
//             $this->currentSession = \App\Models\Session::find($this->selectedSession);
//         }
//     }

//     public function changeSession()
//     {
//         // Save the selected session ID to the session
//         Session::put('current_session_id', $this->selectedSession);

//         // Reload the current session details
//         $this->currentSession = \App\Models\Session::find($this->selectedSession);

//         // Optionally, you can perform any additional logic or database updates here
//     }

//     public function render()
//     {
//         return view('livewire.call-manager');
//     }
// }



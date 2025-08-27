<?php

namespace App\Http\Livewire\Live\Supervisor;

use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Auth;  // Correct Auth import
use App\Models\Live\CCAgent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Livewire\Component;

class AgentActvity extends Component
{

    public $server;
    public function mount()
    {
        $this->server = config("app.API_SERVER_ENDPOINT");
    }
    public function render()
    {

        $api_server = config("app.API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");
        $sessions = CallSession::all();

        $availableAgents = CCAgent::where(function ($query) {
            $query->whereIn('state', ['AgentState.LOGGEDIN', 'LOGGED_IN']);
        })->get();

        $agentStatuses=$this->probAgents();
        // dd($agentStatuses);

        $totalAgentCount = CCAgent::count();
        return view('livewire.live.supervisor.agent-actvity', [
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'sessions' => $sessions,
            'user' => Auth::user(), // Add authenticated user data
            'availableAgents' => $availableAgents,
            'totalAgentCount' => $totalAgentCount,
            'agentStatuses' => $agentStatuses
        ]);
    }


    public function probAgents()
    {
        // 1. Initialize an array to hold the results for the frontend
        $results = [];

        $loggedInAgents =  $availableAgents = CCAgent::where(function ($query) {
            $query->whereIn('state', ['AgentState.LOGGEDIN', 'LOGGED_IN']);
        })->get();

        foreach ($loggedInAgents as $agent) {
            $statusPayload = [
                'agent_num' => $agent->endpoint,
                'api_status' => null, // The status from the API (true/false)
                'action_taken' => 'none', // What your code did (e.g., 'updated_to_offline')
            ];



            try {

                $agentResponse = Http::get("http://10.44.0.56:8001". '/online/' . $agent->endpoint);


                // if (!$agentResponse->successful()) {
                //     Log::warning("API request failed for agent {$agent->endpoint}: Server responded with status " . $agentResponse->status());
                //     continue;
                // }

                $agentData = $agentResponse->json();

                $isOnline = $agentData['status'] === true;
                $statusPayload['api_status'] = $isOnline;

                if (!$isOnline) {
                    // If the agent is offline, update the DB and record the action

                    $statusPayload['action_taken'] = 'updated_to_offline';
                    Log::info("Agent {$agent->endpoint} was found offline. Status updated.");
                } else {
                    // If the agent is online as expected, just record that no action was needed
                    $statusPayload['action_taken'] = 'unchanged_online';
                }

            } catch (\Exception $e) {
                Log::error("Failed to sync status for agent {$agent->endpoint}: " . $e->getMessage());
                $statusPayload['action_taken'] = 'error';


            }

            // 2. Add the result for this agent to our results array
            $results[] = $statusPayload;
        }

        // 3. Emit an event with the collected results for the frontend to catch
        return $results;
    }
}

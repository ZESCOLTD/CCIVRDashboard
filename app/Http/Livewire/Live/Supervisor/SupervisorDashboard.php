<?php

namespace App\Http\Livewire\Live\Supervisor;

use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Auth;  // Correct Auth import
use Illuminate\Support\Facades\Cache; // Correct import statement

use App\Models\Live\CCAgent;

use App\Models\Live\Recordings as LiveRecordings;

use Carbon\Carbon;
use Livewire\Component;
use DateTime;
use Exception; // Also good to import if you're catching exceptions

class SupervisorDashboard extends Component
{
    public function render()
    {
        $api_server = config("app.API_SERVER_ENDPOINT");
        // env("API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");
        $sessions = CallSession::all();

        // $availableAgentsCount = CCAgent::where('state', '=', 'AgentState.LOGGEDIN')
        // ->orWhere('state', '=', 'LOGGED_IN')
        // ->count();


        // $loggedInAgentsCount = CCAgent::where('state', '=', 'AgentState.LOGGEDIN')
        // ->orWhere('state', '=', 'LOGGED_IN')
        // ->where('status', '=', 'IDLE')
        // ->orWhere('status', '=', 'AgentState.IDLE')
        // ->count();

        // Count all agents in LOGGED_IN state (grouped correctly)
    $availableAgentsCount = CCAgent::where(function ($query) {
        $query->where('state', 'AgentState.LOGGEDIN')
              ->orWhere('state', 'LOGGED_IN');
    })->count();

    $activeCalls = CCAgent::where('status', 'AgentState.ONCONVERSATION')
    ->count();

    $totalAgentCount = CCAgent::count();

    $onBreak = CCAgent::where('status', 'AgentState.ONWITHDRAW')
    ->count();

    $answeredCalls = LiveRecordings::whereDate('created_at', Carbon::today())->count();

    $loggedOut = CCAgent::whereNotIn('state', ['AgentState.LOGGEDIN', 'LOGGED_IN'])->count();

// For the current week (starting Monday)
$answeredCallsThisWeek = LiveRecordings::whereBetween('created_at', [
    Carbon::now()->startOfWeek(), // or startOfWeek(Carbon::MONDAY)
    Carbon::now()->endOfWeek()
])->count();
$answeredCallsThisMonth = LiveRecordings::whereBetween('created_at', [
    Carbon::now()->startOfMonth(),
    Carbon::now()->endOfMonth()
])->count();

    // Count only LOGGED_IN agents who are also IDLE (grouped correctly)
    $loggedInAgentsCount = CCAgent::where(function ($query) {
        $query->where('state', 'AgentState.LOGGEDIN')
              ->orWhere('state', 'LOGGED_IN');
    })->where(function ($query) {
        $query->where('status', 'IDLE')
              ->orWhere('status', 'AgentState.IDLE');
    })->count();
        //$ws_server = env("WS_SERVER_ENDPOINT");
        //dd([$api_server, $ws_server]);
        return view('livewire.live.supervisor.supervisor-dashboard', [
            'api_server' => $api_server,
            'ws_server' => $ws_server,
            'sessions' => $sessions,
            'user' => Auth::user(), // Add authenticated user data
            'availableAgentsCount' => $availableAgentsCount,
            'loggedInAgentsCount' => $loggedInAgentsCount,
            'activeCalls' => $activeCalls,
            'answeredCalls' => $answeredCalls,
            'onBreak' => $onBreak,
            'loggedOut' => $loggedOut,
            'totalAgentCount' => $totalAgentCount,
            'answeredCallsThisWeek' => $answeredCallsThisWeek,
            'answeredCallsThisMonth' => $answeredCallsThisMonth,
        ]);
    }

    public function processBridgeData(array $bridges): array
{
    $result = [
        'total_bridges' => count($bridges),
        'bridge_types' => [],
        'active_bridges' => 0,
        'inactive_bridges' => 0,
        'bridges_by_technology' => [],
        'bridges_by_date' => [],
        'detailed_bridges' => []
    ];

    foreach ($bridges as $bridge) {
        // Count bridge types
        $bridgeType = $bridge['bridge_type'] ?? 'unknown';
        if (!isset($result['bridge_types'][$bridgeType])) {
            $result['bridge_types'][$bridgeType] = 0;
        }
        $result['bridge_types'][$bridgeType]++;

        // Count active/inactive bridges (active = has channels)
        $isActive = !empty($bridge['channels']);
        if ($isActive) {
            $result['active_bridges']++;
        } else {
            $result['inactive_bridges']++;
        }

        // Group by technology
        $technology = $bridge['technology'] ?? 'unknown';
        if (!isset($result['bridges_by_technology'][$technology])) {
            $result['bridges_by_technology'][$technology] = [];
        }
        $result['bridges_by_technology'][$technology][] = $bridge['id'] ?? 'unknown';

        // Extract date from creationtime
        try {
            $creationDate = (new DateTime($bridge['creationtime'] ?? 'now'))->format('Y-m-d');
        } catch (Exception $e) {
            $creationDate = 'invalid-date';
        }

        if (!isset($result['bridges_by_date'][$creationDate])) {
            $result['bridges_by_date'][$creationDate] = 0;
        }
        $result['bridges_by_date'][$creationDate]++;

        // Store detailed bridge info
        $result['detailed_bridges'][] = [
            'id' => $bridge['id'] ?? 'unknown',
            'type' => $bridgeType,
            'technology' => $technology,
            'active' => $isActive,
            'creation_date' => $creationDate,
            'channels_count' => count($bridge['channels'] ?? []),
            'video_mode' => $bridge['video_mode'] ?? null
        ];
    }

    krsort($result['bridges_by_date']);

    return $result;
}

}

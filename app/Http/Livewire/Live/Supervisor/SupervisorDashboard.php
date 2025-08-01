<?php

namespace App\Http\Livewire\Live\Supervisor;

use App\Models\Live\CallSession;
use Illuminate\Support\Facades\Auth;  // Correct Auth import
use Illuminate\Support\Facades\Cache; // Correct import statement

use App\Models\Live\CCAgent;
use App\Models\Live\DialEventLog;

use App\Models\Live\Recordings as LiveRecordings;

use Carbon\Carbon;
use Livewire\Component;
use DateTime;
use Exception; // Also good to import if you're catching exceptions


class SupervisorDashboard extends Component
{
    public $onBreakCount = 0;

    protected $listeners = [
        'refreshComponent' => 'refreshComponent',
    ];

    public function refreshComponent()
    {
        $this->render();
    }


    public function mount()
    {
        $this->updateBreakCount(); // optional call here
    }

    public function updateBreakCount()
    {
        $this->onBreakCount = \App\Models\Live\CCAgent::where('status', config('constants.agent_status.ON_BREAK'))->count();
    }

    public function render()
    {
        $api_server = config("app.API_SERVER_ENDPOINT");
        $ws_server = config("app.WS_SERVER_ENDPOINT");
        $sessions = CallSession::all();

        $calls = DialEventLog::orderBy('event_timestamp')
            ->whereDate('created_at', Carbon::today())
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

        $answered = count($callResults->where('status', 'ANSWER'));
        $missed = count($callResults->where('status', 'NOANSWER'));
        $total = count($callResults);


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

        // $abandoned = LiveRecordings::whereDate('created_at', Carbon::today())
        // ->whereDate('agent_no', "empty")

        // ->count();


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
            $query->whereIn('state', ['AgentState.LOGGEDIN','LOGGED_IN']);
                // ->orWhere('state', 'LOGGED_IN');
        })->where(function ($query) {
            $query->whereIn('status', ['IDLE','AgentState.IDLE']);
                // ->orWhere('status', 'AgentState.IDLE');
        })->count();

        // answered calls in the last 30 minutes
        $answeredCallsLast30 = LiveRecordings::where('created_at', '>=', Carbon::now()->subMinutes(30))
            ->count();



        // available agents right now (as proxy for last-30min availability)
        $availableAgentsNow = CCAgent::where(function ($q) {
            $q->where('state', 'AgentState.LOGGEDIN')
                ->orWhere('state', 'LOGGED_IN');
        })->count();

        // efficiency in last 30 minutes
        $efficiencyLast30 = 0;
        if ($availableAgentsNow > 0) {
            $efficiencyLast30 = ($answeredCallsLast30 / $availableAgentsNow);
        }


        $today = now()->toDateString(); // or Carbon::today()
        $callsQuery = LiveRecordings::whereDate('created_at', $today);

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

        $agentStatusData = [
            [
                'name' => 'Logged In / Idle',
                'y' => $availableAgentsCount,
                'color' => '#28a745' // Green
            ],
            [
                'name' => 'On a Call',
                'y' => $availableAgentsCount - $loggedInAgentsCount,
                'color' => '#007bff' // Blue
            ],
            [
                'name' => 'On Break',
                'y' => $onBreak,
                'color' => '#ffc107' // Yellow
            ],
            [
                'name' => 'Total',
                'y' => $totalAgentCount,
                'color' => '#dc3545' // Red
            ],

        ];

        // Prepare data for a Call Outcome Highcharts chart
$callOutcomeData = [
    [
        'name' => 'Answered',
        'y' => $answered,
        'color' => '#28a745' // Green for answered
    ],
    [
        'name' => 'Missed',
        'y' => $missed,
        'color' => '#ffc107' // Yellow for missed
    ],
    [
        'name' => 'Abandoned',
        'y' => ($total - ($missed + $answered)), // Use the calculated abandoned value
        'color' => '#dc3545' // Red for abandoned
    ],
];



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
            'answered' => $answered,
            'missed' => $missed,
            'onBreak' => $onBreak,
            'loggedOut' => $loggedOut,
            'totalAgentCount' => $totalAgentCount,
            'answeredCallsThisWeek' => $answeredCallsThisWeek,
            'answeredCallsThisMonth' => $answeredCallsThisMonth,
            'answeredCallsLast30' => $answeredCallsLast30,
            'abandoned' => $total - ($missed + $answered),
            'totalCalls' => $total,
            'efficencyLast30' => ceil($efficiencyLast30),
            'averageDurationFormatted' => $averageDurationFormatted,
            'agentStatusData' => json_encode($agentStatusData),
            'callOutcomeData' => json_encode($callOutcomeData),
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

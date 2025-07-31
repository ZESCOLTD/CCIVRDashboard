<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Exports\GeneralReportExport;
use Carbon\Carbon;
use App\Mail\ReportEmail;
use App\Models\CDR\CallDetailsRecordModel;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Models\Configs\ConfigDestinationsModel;
use App\Models\Live\CCAgent;
use App\Models\Live\Recordings;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

use App\Models\Live\DialEventLog;

class GeneralReport extends Component
{
    public $agent;
    public $agents = [];
    public $queues = [];
    public $startDate;
    public $endDate;
    public $startTime;
    public $endTime;
    public $label;
    public $from;
    public $to;
    public $summary_calls_today;
    public $reportType;
    public $agentIds = [];
    public $queueIds = [];
    // Report data properties
    public $reportData = null;
    public $reportTitle = '';
    public $dateRange = '';
    public $isLoading = false;
    public $selectedAgent = ''; // optional
    // Email properties
    public $emailRecipients = '';
    public $total_calls_yesterday;
    public $emailSubject = '';
    public $emailMessage = '';
    // Automated reports
    public $autoDaily = false;
    public $autoWeekly = false;
    public $recipients = '';

    protected $listeners = ['reportGenerated' => 'handleReportGenerated', 'dataUpdate'];

    public function mount()
    {
        $this->agents = CCAgent::all();
        $this->queues = $this->getQueueList();
        $this->reportType = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->startTime = null;
        $this->endTime = null;
        $this->agents = CCAgent::select('id', 'name')->orderBy('name')->get();
    }

    public function updatedReportType($value)
    {

        // dd($value);

        $this->startDate = null;
        $this->endDate = null;
        $this->startTime = null;
        $this->endTime = null;
        $this->reset(['startDate', 'endDate', 'startTime', 'endTime', 'reportData']);

        if ($value === 'weekly') {
            $this->startDate = now()->startOfWeek()->format('Y-m-d');
            $this->endDate = now()->endOfWeek()->format('Y-m-d');
        } else {
            $this->startDate = now()->format('Y-m-d');
            $this->endDate = now()->format('Y-m-d');
        }
    }



    public function generateReport()
    {

        $this->validate([
            'reportType' => 'required|in:daily,weekly,agent,queue,sms,transaction',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'startTime' => 'nullable|date_format:H:i',
            'endTime' => 'nullable|date_format:H:i|after_or_equal:startTime',
            'agentIds' => 'nullable|array',
            'queueIds' => 'nullable|array',
        ]);

        $this->isLoading = true;

        try {
            // Process dates
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);

            // Apply time filters if provided
            if (!empty($this->startTime) && !empty($this->endTime)) {
                $startDate->setTimeFromTimeString($this->startTime);
                $endDate->setTimeFromTimeString($this->endTime);
            } else {
                $startDate->startOfDay();
                $endDate->endOfDay();
            }


            // Generate report based on type
            switch ($this->reportType) {
                case 'daily':
                    $this->generateDailyReport($startDate, $endDate);
                    $this->reportTitle = 'Daily Report - ' . $startDate->format('Y-m-d');
                    break;

                case 'weekly':
                    $this->generateWeeklyReport($startDate, $endDate);
                    $this->reportTitle = 'Weekly Report - Week of ' . $startDate->format('Y-m-d');
                    break;

                case 'agent':

                    $this->generateAgentPerformanceReport($startDate, $endDate);
                    $this->reportTitle = 'Agent Performance Report';
                    break;

                case 'queue':
                    $this->generateQueuePerformanceReport($startDate, $endDate);
                    $this->reportTitle = 'Queue Performance Report';
                    break;

                case 'sms':
                    $this->generateSMSReport($startDate, $endDate);
                    $this->reportTitle = 'SMS Broadcast Report';
                    break;

                case 'transaction':

                    $this->generateTransactionCodeReport($startDate, $endDate);
                    $this->reportTitle = 'Transaction Code Report';
                    break;

                default:
                    throw new \InvalidArgumentException("Unknown report type: " . $this->reportType);
            }


            $this->dateRange = $startDate->format('Y-m-d H:i') . ' to ' . $endDate->format('Y-m-d H:i');
            $this->dispatchBrowserEvent('report-generated');
        } catch (\Exception $e) {
            Log::error('Report generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $this->getPublicPropertiesDefinedBySubClass()
            ]);

            $this->dispatchBrowserEvent('show-error', [
                'message' => 'Error generating report: ' . $e->getMessage()
            ]);
        } finally {
            $this->isLoading = false;
        }
    }



    // protected function generateDailyReport($startDate, $endDate)
    // {
    //     $queues = $this->getQueueIds();
    //     if (empty($queues)) {
    //         $this->reportData = [];
    //         return;
    //     }

    //     $this->reportData = CallDetailsRecordModel::query()
    //         ->select([
    //             DB::raw('dst as label'),
    //             DB::raw('count(*) as total_calls'),
    //             DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
    //             DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
    //             DB::raw('avg(duration) as avg_duration')
    //         ])
    //         ->whereBetween('calldate', [$startDate, $endDate])
    //         ->whereIn('dst', $queues)
    //         ->groupBy('dst')
    //         ->orderByRaw($this->getQueueOrderBy()) // ✅ Custom order using FIELD
    //         ->paginate()
    //         ->toArray()['data'];
    // }
    // protected function generateDailyReport($startDate, $endDate)
    // {
    //     // Hardcoded queue destinations based on CallSummaryRecords::render()
    //     $queues = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17', 'cc-21'];

    //     if (empty($queues)) {
    //         $this->reportData = [];
    //         return;
    //     }

    //     // Hardcoded orderByRaw string based on CallSummaryRecords::render()
    //     $queueOrderByRaw = "FIELD(dst , 'cc-3', 'cc-7', 'cc-13', 'cc-15','cc-20', 'cc-6','cc-18', 'cc-4', 'cc-14','cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12','cc-16', 'cc-17','cc-21') ASC";

    //     $this->reportData = CallDetailsRecordModel::query()
    //         ->select([
    //             DB::raw('dst as label'),
    //             DB::raw('count(*) as total_calls'),
    //             DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
    //             DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
    //             DB::raw('avg(duration) as avg_duration')
    //         ])
    //         ->whereBetween('calldate', [$startDate, $endDate])
    //         ->whereIn('dst', $queues)
    //         ->groupBy('dst')
    //         ->orderByRaw($queueOrderByRaw) // Uses the hardcoded order
    //         ->get() // Changed from paginate() to get()
    //         ->toArray(); // Convert collection to array
    //         dd($this->reportData); // Debugging line to check the output
    // }

    protected function generateDailyReport($startDate, $endDate)
    {
        $queues = ['cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18', 'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12', 'cc-16', 'cc-17', 'cc-21'];

        if (empty($queues)) {
            $this->reportData = [];
            return;
        }

        $queueOrderByRaw = "FIELD(dst , 'cc-3', 'cc-7', 'cc-13', 'cc-15','cc-20', 'cc-6','cc-18', 'cc-4', 'cc-14','cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12','cc-16', 'cc-17','cc-21') ASC";

        // Step 1: Run your original, working aggregation query
        $aggregatedData = CallDetailsRecordModel::query()
            ->select([
                DB::raw('dst as label'),
                DB::raw('count(*) as total_calls'),
                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
                DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
                DB::raw('avg(duration) as avg_duration')
            ])
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereIn('dst', $queues)
            ->groupBy('dst')
            ->orderByRaw($queueOrderByRaw)
            ->get()
            ->toArray();

        // Step 2: Get all relevant destination descriptions from ConfigDestinationsModel
        // Use 'description' instead of 'name'
        $destinationConfigs = ConfigDestinationsModel::whereIn('destination', $queues)
            ->get(['destination', 'description']) // <-- Changed 'name' to 'description'
            ->keyBy('destination')
            ->toArray();

        // Step 3: Create a simple lookup map
        $destinationDescriptions = [];
        foreach ($destinationConfigs as $destinationCode => $config) {
            $destinationDescriptions[$destinationCode] = $config['description']; // <-- Changed 'name' to 'description'
        }

        // Step 4: Loop through aggregated data and add the destination description
        $finalReportData = [];
        foreach ($aggregatedData as $row) {
            $destinationLabel = $row['label']; // This is your 'dst' value

            // Check if we have a matching description in our lookup map
            $row['my_destination_name'] = $destinationDescriptions[$destinationLabel] ?? 'Unknown Destination'; // Keep alias consistent

            $finalReportData[] = $row;
        }

        $this->reportData = $finalReportData;
    }


    protected function getQueueOrderBy()
    {
        $queues = $this->getQueueIds();
        if (empty($queues)) return 'dst ASC';

        $quotedQueues = array_map(fn($q) => DB::getPdo()->quote($q), $queues);
        return "FIELD(dst, " . implode(', ', $quotedQueues) . ")";
    }


    protected function generateWeeklyReport($startDate, $endDate)
    {
        $queues = $this->getQueueIds();
        if (empty($queues)) {
            $this->reportData = [];
            return;
        }

        $this->reportData = CallDetailsRecordModel::query()
            ->select([
                DB::raw('DATE(calldate) as label'),
                DB::raw('count(*) as total_calls'),
                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
                DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
                DB::raw('avg(duration) as avg_duration'),
                DB::raw('HOUR(calldate) as hour'),
                DB::raw('count(case when wait_time <= 20 then 1 else null end) as sla_compliant')
            ])
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereIn('dst', $queues)
            ->groupBy(DB::raw('DATE(calldate)'))
            ->orderBy('label')
            ->get()
            ->map(function ($item) {
                $total = $item->total_calls ?: 1;

                return [
                    'label' => $item->label,
                    'total_calls' => $item->total_calls,
                    'answered' => $item->answered,
                    'abandoned' => $item->abandoned,
                    'avg_duration' => gmdate("H:i:s", (int) $item->avg_duration),
                    'peak_hour' => $item->hour,
                    'sla_compliance' => round(($item->sla_compliant / $total) * 100, 2),
                ];
            })
            ->toArray();
    }


    /**
     * Generate agent performance report
     *
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @param int|null $selectedAgent
     */


    // protected function generateAgentPerformanceReport($startDate, $endDate, $selectedAgent = null)
    // {
    //     try {
    //         $agents = \App\Models\Live\CCAgent::select('id', 'name', 'endpoint')->get()->keyBy('endpoint');

    //         $subQueryAbandoned = DB::table('cdr')
    //             ->select('dst', DB::raw('COUNT(*) as abandoned'))
    //             ->whereBetween('calldate', [$startDate, $endDate]) // Added date filter
    //             ->groupBy('dst');

    //         // Main query
    //         $query = DB::table('recordings as r')
    //             ->select(
    //                 'r.dst',
    //                 DB::raw('COUNT(*) as answered'),
    //                 'cdr_sub.abandoned'
    //             )
    //             ->leftJoinSub($subQueryAbandoned, 'cdr_sub', 'cdr_sub.dst', '=', 'r.dst')
    //             ->limit(10)
    //             ->whereNotNull('r.dst')
    //             ->whereBetween('r.created_at', [$startDate, $endDate]); // Assuming recordings have 'created_at'

    //         // Apply filter if agent is selected
    //         if (!empty($selectedAgent)) {
    //             $agent = \App\Models\Live\CCAgent::find($selectedAgent);
    //             if ($agent) {
    //                 $query->where('r.dst', $agent->endpoint);
    //             }
    //         }

    //         $results = $query->groupBy('r.dst', 'cdr_sub.abandoned')->get();

    //         $this->reportData = $results->map(function ($item) use ($agents, $startDate, $endDate) {
    //             // When fetching recordings for duration calculation, also apply date filters
    //             $recordings = Recordings::where('dst', $item->dst)
    //                                     ->whereBetween('created_at', [$startDate, $endDate]) // Apply date filter
    //                                     ->get();
    //             $totalSeconds = $recordings->sum(fn($rec) => $rec->duration_in_seconds ?? 0);
    //             $count = $recordings->count();
    //             $avgSeconds = $count > 0 ? (int) ($totalSeconds / $count) : 0;

    //             $answered = $item->answered ?? 0;
    //             $abandoned = $item->abandoned ?? 0;
    //             $totalCalls = $answered + $abandoned;
    //             $satisfaction = $totalCalls > 0 ? round(($answered / $totalCalls) * 100, 2) : 0;

    //             if ($satisfaction >= 90) {
    //                 $rating = 'Excellent';
    //             } elseif ($satisfaction >= 75) {
    //                 $rating = 'Good';
    //             } elseif ($satisfaction >= 50) {
    //                 $rating = 'Fair';
    //             } else {
    //                 $rating = 'Poor';
    //             }

    //             return [
    //                 'label' => $item->dst,
    //                 'dst' => $item->dst,
    //                 'agent_name' => $agents[$item->dst]->name ?? 'Unknown',
    //                 'total_calls' => $totalCalls,
    //                 'answered' => $answered,
    //                 'abandoned' => $abandoned,
    //                 'avg_duration' => gmdate('H:i:s', $avgSeconds),
    //                 'satisfaction' => $satisfaction . '%',
    //                 'rating' => $rating,
    //             ];
    //         })->toArray();



    //     } catch (\Exception $e) {

    //         $this->reportData = [];

    //         // Log the error if needed
    //     }
    // }

    // protected function generateAgentPerformanceReport($startDate, $endDate)
    // {
    //     try {
    //         $agents = CCAgent::select('id', 'name', 'endpoint')->get();
    //         $reportResults = [];

    //         // If specific agents are selected, filter the agents list
    //         $targetAgents = $this->agentIds ? $agents->whereIn('id', $this->agentIds) : $agents;

    //         foreach ($targetAgents as $agent) {
    //             $agentEndpoint = $agent->endpoint;

    //             // --- Logic inspired by DashboardController's render method ---
    //             // Get call events for the agent within the date range
    //             $callEvents = DialEventLog::where('dialstring', $agentEndpoint)
    //                 ->whereBetween('event_timestamp', [$startDate, $endDate])
    //                 ->get()
    //                 ->groupBy(function ($event) {
    //                     return $event->dialstring . '_' . $event->peer_id . '_' . $event->caller_number;
    //                 });


    //             $answered = 0;
    //             $missed = 0;

    //             foreach ($callEvents as $key => $events) {
    //                 $sorted = $events->sortBy('event_timestamp');
    //                 $lastWithStatus = $sorted->reverse()->first(fn($e) => !empty($e->dialstatus));
    //                 if ($lastWithStatus) {
    //                     if ($lastWithStatus->dialstatus === 'ANSWER') {
    //                         $answered++;
    //                     } elseif ($lastWithStatus->dialstatus === 'NOANSWER') {
    //                         $missed++;
    //                     }
    //                 }
    //             }

    //             // Get recordings for the agent within the date range
    //             $agentRecordings = Recordings::where('agent_number', 'LIKE', "%{$agentEndpoint}%")
    //                 ->whereBetween('created_at', [$startDate, $endDate])
    //                 ->get();


    //             $totalDurationInSeconds = $agentRecordings->sum('duration_in_seconds');
    //             $recordCount = $agentRecordings->count();

    //             $avgSeconds = $recordCount > 0 ? (int) ($totalDurationInSeconds / $recordCount) : 0;
    //             // --- End of DashboardController inspired logic ---

    //             $totalCalls = $answered + $missed;
    //             $satisfaction = $totalCalls > 0 ? round(($answered / $totalCalls) * 100, 2) : 0;

    //             if ($satisfaction >= 90) {
    //                 $rating = 'Excellent';
    //             } elseif ($satisfaction >= 75) {
    //                 $rating = 'Good';
    //             } elseif ($satisfaction >= 50) {
    //                 $rating = 'Fair';
    //             } else {
    //                 $rating = 'Poor';
    //             }

    //             $reportResults[] = [
    //                 'label' => $agent->name, // Agent's name as label
    //                 'agent_id' => $agent->id,
    //                 'agent_endpoint' => $agentEndpoint,
    //                 'total_calls' => $totalCalls,
    //                 'answered' => $answered,
    //                 'missed' => $missed,
    //                 'avg_duration' => gmdate('H:i:s', $avgSeconds),
    //                 'satisfaction' => $satisfaction . '%',
    //                 'rating' => $rating,
    //             ];
    //         }

    //         $this->reportData = $reportResults;

    //     } catch (\Exception $e) {
    //         $this->reportData = [];
    //         Log::error('Agent Performance Report generation failed: ' . $e->getMessage(), [
    //             'exception' => $e,
    //             'startDate' => $startDate,
    //             'endDate' => $endDate,
    //             'agentIds' => $this->agentIds,
    //         ]);
    //     }
    // }

    protected function generateAgentPerformanceReport($startDate, $endDate)
    {
        try {
            $agents = CCAgent::select('id', 'name', 'endpoint')->get();
            $reportResults = [];

            // If specific agents are selected, filter the agents list
            $targetAgents = $this->agentIds ? $agents->whereIn('id', $this->agentIds) : $agents;

            foreach ($targetAgents as $agent) {
                $agentEndpoint = $agent->endpoint;

                // --- Logic inspired by DashboardController's render method ---
                // Get call events for the agent within the date range
                $callEvents = DialEventLog::where('dialstring', $agentEndpoint)
                    ->whereBetween('event_timestamp', [$startDate, $endDate])
                    ->get()
                    ->groupBy(function ($event) {
                        return $event->dialstring . '_' . $event->peer_id . '_' . $event->caller_number;
                    });


                $answered = 0;
                $missed = 0;

                foreach ($callEvents as $key => $events) {
                    $sorted = $events->sortBy('event_timestamp');
                    $lastWithStatus = $sorted->reverse()->first(fn($e) => !empty($e->dialstatus));
                    if ($lastWithStatus) {
                        if ($lastWithStatus->dialstatus === 'ANSWER') {
                            $answered++;
                        } elseif ($lastWithStatus->dialstatus === 'NOANSWER') {
                            $missed++;
                        }
                    }
                }

                // Get recordings for the agent within the date range
                $agentRecordings = Recordings::where('agent_number', 'LIKE', "%{$agentEndpoint}%")
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();


                $totalDurationInSeconds = $agentRecordings->sum('duration_in_seconds');
                $recordCount = $agentRecordings->count();

                $avgSeconds = $recordCount > 0 ? (int) ($totalDurationInSeconds / $recordCount) : 0;
                // --- End of DashboardController inspired logic ---

                $totalCalls = $answered + $missed;
                $satisfaction = $totalCalls > 0 ? round(($answered / $totalCalls) * 100, 2) : 0;

                if ($satisfaction >= 90) {
                    $rating = 'Excellent';
                } elseif ($satisfaction >= 75) {
                    $rating = 'Good';
                } elseif ($satisfaction >= 50) {
                    $rating = 'Fair';
                } else {
                    $rating = 'Poor';
                }

                // Only add agent to report if they have total calls greater than 0
                if ($totalCalls > 0) { //
                    $reportResults[] = [
                        'label' => $agent->name, // Agent's name as label
                        'agent_id' => $agent->id,
                        'agent_endpoint' => $agentEndpoint,
                        'total_calls' => $totalCalls,
                        'answered' => $answered,
                        'missed' => $missed,
                        'avg_duration' => gmdate('H:i:s', $avgSeconds),
                        'satisfaction' => $satisfaction . '%',
                        'rating' => $rating,
                    ];
                }
            }

            $this->reportData = $reportResults;

            // dd($this->reportData); // Debugging line to check the output
        } catch (\Exception $e) {
            $this->reportData = [];
            Log::error('Agent Performance Report generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'agentIds' => $this->agentIds,
            ]);
        }
    }

    // protected function generateQueuePerformanceReport($startDate, $endDate)
    // {
    //     $this->reportData = CallDetailsRecordModel::query()
    //         ->select(
    //             'dst as label',
    //             DB::raw('count(*) as total_calls'),
    //             DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
    //             DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
    //             DB::raw('avg(wait_time) as avg_wait_time'),
    //             DB::raw('max(wait_time) as max_wait_time'),
    //             DB::raw('count(case when wait_time <= 20 then 1 else null end) as sla_compliant')
    //         )
    //         ->whereBetween('calldate', [$startDate, $endDate])
    //         ->whereIn('dst', $this->queueIds ?: $this->getQueueIds())
    //         ->groupBy('dst')
    //         ->orderBy('total_calls', 'desc')
    //         ->get()
    //         ->map(function ($item) {
    //             $item->abandon_rate = $item->total_calls > 0
    //                 ? round(($item->abandoned / $item->total_calls) * 100, 2)
    //                 : 0;
    //             $item->sla_compliance = $item->total_calls > 0
    //                 ? round(($item->sla_compliant / $item->total_calls) * 100, 2)
    //                 : 0;
    //             return $item;
    //         })
    //         ->toArray();
    // }

    protected function generateQueuePerformanceReport($startDate, $endDate)
    {
        try {
            $reportResults = [];

            // Get all unique endpoints that are associated with agents (CCAgent::endpoint)
            // as these are the "queues" that agents are part of.
            $allAgentEndpoints = CCAgent::distinct('endpoint')->pluck('endpoint')->filter()->values()->toArray();

            // Filter these endpoints based on selected queueIds if provided.
            // If no specific queueIds are selected, consider all agent endpoints as part of the overall queue.
            $targetEndpointsForQueue =  $allAgentEndpoints;

            // Initialize aggregated totals for the "Overall Queue Performance"
            $totalAnswered = 0;
            $totalMissed = 0;
            $totalDurationAllQueues = 0;
            $totalRecordCountAllQueues = 0;


            // Iterate through each relevant endpoint to sum up their statistics
            foreach ($targetEndpointsForQueue as $endpoint) {
                // Aggregate call events for this specific endpoint (queue)
                // $callEvents = DialEventLog::where('dialstring', $endpoint)
                //     ->whereBetween('event_timestamp', [$startDate, $endDate])
                //     ->get()
                //     ->groupBy(function ($event) {
                //         return $event->dialstring . '_' . $event->peer_id . '_' . $event->caller_number;
                //     });


                $callEvents = DialEventLog::orderBy('event_timestamp')
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->get()
                    ->groupBy(function ($event) {
                        return $event->dialstring . '_' . $event->peer_id;
                    });

                $callResults = $callEvents->map(function ($events, $key) {
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


                $answeredForEndpoint = count($callResults->where('status', 'ANSWER')
                    ->where('dialstring', $endpoint));
                $missedForEndpoint = count($callResults->where('status', 'NOANSWER')
                    ->where('dialstring', $endpoint));

                $totalAnswered += $answeredForEndpoint;
                $totalMissed += $missedForEndpoint;

                // Aggregate recordings for this specific endpoint (queue)




                // $totalDurationForEndpoint = $recordingsForEndpoint->sum('duration_in_seconds');


                // $recordCountForEndpoint = $recordingsForEndpoint->count();

                // $totalDurationAllQueues += $totalDurationForEndpoint;
                // $totalRecordCountAllQueues += $recordCountForEndpoint;
            }

            $recordingsForEndpoints = Recordings::whereBetween('created_at', [$startDate, $endDate])
                ->get();

            $totalDurationAllQueues = $recordingsForEndpoints->sum('duration_in_seconds');
            $totalRecordCountAllQueues = $recordingsForEndpoints->count();

            $overallTotalCalls = $totalAnswered + $totalMissed;

            $overallAvgDurationSeconds = $totalRecordCountAllQueues > 0 ? (int) ($totalDurationAllQueues / $totalRecordCountAllQueues) : 0;
            $overallSatisfaction = $overallTotalCalls > 0 ? round(($totalAnswered / $overallTotalCalls) * 100, 2) : 0;

            $overallRating = 'Poor';
            if ($overallSatisfaction >= 90) {
                $overallRating = 'Excellent';
            } elseif ($overallSatisfaction >= 75) {
                $overallRating = 'Good';
            } elseif ($overallSatisfaction >= 50) {
                $overallRating = 'Fair';
            }

            // Only add the overall queue report if there are total calls
            if ($overallTotalCalls > 0) {
                $reportResults[] = [
                    'label' => 'Overall Queue Performance', // A single label for the aggregated report
                    'total_calls' => $overallTotalCalls,
                    'answered' => $totalAnswered,
                    'missed' => $totalMissed,
                    'avg_duration' => gmdate('H:i:s', $overallAvgDurationSeconds),
                    'satisfaction' => $overallSatisfaction . '%',
                    'rating' => $overallRating,
                ];
            }

            $this->reportData = $reportResults;
        } catch (\Exception $e) {
            $this->reportData = [];
            Log::error('Queue Performance Report generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'queueIds' => $this->queueIds, // Keep this for logging purposes
            ]);
        }
    }


    protected function generateSMSReport($startDate, $endDate)
    {
        // This is a placeholder - implement your SMS report logic
        $this->reportData = [
            [
                'label' => 'Campaign 1',
                'sent' => 1000,
                'delivered' => 950,
                'failed' => 50,
                'delivery_rate' => 95,
                'response_rate' => 15,
                'opt_outs' => 5
            ],
            [
                'label' => 'Campaign 2',
                'sent' => 800,
                'delivered' => 760,
                'failed' => 40,
                'delivery_rate' => 95,
                'response_rate' => 12,
                'opt_outs' => 3
            ]
        ];
    }

    protected function generateTransactionCodeReport($startDate, $endDate)
    {
        try {
            // Fetch recordings within the date range that have a transaction code
            $recordings = Recordings::with('tCode') // Eager load the transaction code relationship
                // ->whereNotNull('transaction_code')
                ->whereBetween('hangupdate', [$startDate, $endDate])
                ->get();

            // dd($recordings);
            // Group recordings by transaction code
            $groupedRecordings = $recordings->groupBy('transaction_code');



            $reportResults = [];

            foreach ($groupedRecordings as $transactionCodeValue => $recordingsCollection) {
                $totalCalls = $recordingsCollection->count();
                // $totalDurationSeconds = $recordingsCollection->sum('billsec'); // Summing the billsec attribute

                // Get the transaction code name from the first recording in the group
                // Assuming all recordings in a group have the same transaction code name
                $transactionCodeName = $recordingsCollection->first()->tCode->name ?? 'No Transaction Code: ' . $transactionCodeValue . ')';

                // $avgDurationSeconds = $totalCalls > 0 ? (int) ($totalDurationSeconds / $totalCalls) : 0;

                $reportResults[] = [
                    'label' => $transactionCodeName,
                    'transaction_code' => $transactionCodeValue,
                    'total_calls' => $totalCalls,
                    // 'total_duration' => gmdate('H:i:s', $totalDurationSeconds),
                    // 'avg_duration' => gmdate('H:i:s', $avgDurationSeconds),
                ];
            }

            // dd($reportResults);

            // Sort the report results by total_calls in descending order
            usort($reportResults, function ($a, $b) {
                return $b['total_calls'] <=> $a['total_calls'];
            });

            // dd($reportResults);

            $this->reportData = $reportResults;
        } catch (\Exception $e) {
            $this->reportData = [];
            Log::error('Transaction Code Report generation failed: ' . $e->getMessage(), [
                'exception' => $e,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]);
        }
    }

    public function exportToExcel()
    {
        return Excel::download(
            new GeneralReportExport($this->reportData, $this->reportTitle),
            strtolower(str_replace(' ', '_', $this->reportTitle)) . '.xlsx'
        );
    }

    public function exportToCSV()
    {
        return Excel::download(
            new GeneralReportExport($this->reportData, $this->reportTitle),
            strtolower(str_replace(' ', '_', $this->reportTitle)) . '.csv'
        );
    }

    public function downloadPDF(Request $request)
    {
        $title = $request->get('title', 'Report');
        $reportData = session('reportData') ?? [];
        $dateRange = $request->get('dateRange', '');

        $pdf = PDF::loadView('exports.report-pdf', [
            'data' => $reportData,
            'title' => $title,
            'dateRange' => $dateRange
        ]);

        return $pdf->download(strtolower(str_replace(' ', '_', $title)) . '.pdf');
    }

    public function exportToPDF()
    {
        $pdf = PDF::loadView('exports.report-pdf', [
            'data' => $this->reportData,
            'title' => $this->reportTitle,
            'dateRange' => $this->dateRange
        ]);

        return $pdf->download(strtolower(str_replace(' ', '_', $this->reportTitle)) . '.pdf');
    }

    public function showEmailModal()
    {
        $this->emailSubject = $this->reportTitle . ' - ' . $this->dateRange;
        $this->emailRecipients = $this->recipients;
        $this->dispatchBrowserEvent('show-email-modal');
    }

    public function sendEmail()
    {
        $this->validate([
            'emailRecipients' => 'required',
            'emailSubject' => 'required',
        ]);

        try {
            Mail::to(explode(',', $this->emailRecipients))
                ->send(new ReportEmail(
                    $this->reportData,
                    $this->reportTitle,
                    $this->emailSubject,
                    $this->emailMessage
                ));

            $this->dispatchBrowserEvent('hide-email-modal');
            $this->dispatchBrowserEvent('show-success', [
                'message' => 'Report has been emailed successfully!'
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('show-error', [
                'message' => 'Failed to send email: ' . $e->getMessage()
            ]);
        }
    }

    public function saveAutomatedSettings()
    {
        // Save automated report settings to database or config
        $this->dispatchBrowserEvent('show-success', [
            'message' => 'Automated report settings saved successfully!'
        ]);
    }

    public function resetSearch()
    {
        $this->reset([
            'reportType',
            'startDate',
            'endDate',
            'startTime',
            'endTime',
            'agentIds',
            'queueIds',
            'reportData',
            'reportTitle',
            'dateRange'
        ]);

        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    protected function getQueueIds()
    {
        return [
            'cc-3',
            'cc-7',
            'cc-13',
            'cc-15',
            'cc-20',
            'cc-6',
            'cc-18',
            'cc-4',
            'cc-14',
            'cc-8',
            'cc-9',
            'cc-10',
            'cc-11',
            'cc-12',
            'cc-16',
            'cc-17',
            'cc-21'
        ];
    }

    protected function getQueueList()
    {
        $reportData = [];

        $queues = [];
        $ids = $this->getQueueIds();

        foreach ($ids as $id) {
            $queues[] = [
                'id' => $id,
                'name' => 'Queue ' . $id
            ];
        }

        return $queues;
    }


    public function render()
    {

        return view('livewire.general-report2');
    }
}

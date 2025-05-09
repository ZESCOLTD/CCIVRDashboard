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
use App\Models\Live\CCAgent;
use App\Models\Live\Recordings;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class GeneralReport extends Component
{
    public $agent;
    public $agents = [];
    public $queues = [];
    public $startDate;
    public $endDate;
    public $startTime;
    public $endTime;
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
            'reportType' => 'required|in:daily,weekly,agent,queue,sms',
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
                default:
                    throw new \InvalidArgumentException("Unknown report type");
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

    protected function generateDailyReport($startDate, $endDate)
    {
        $this->reportData = CallDetailsRecordModel::query()
            ->select([
                DB::raw('dst as label'),
                DB::raw('count(*) as total_calls'),
                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
                DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
                DB::raw('avg(duration) as avg_duration')
            ])
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereIn('dst', $this->getQueueIds())
            ->groupBy('dst')
            ->orderBy('total_calls', 'desc')
            ->paginate()
            ->toArray()['data'];
    }

    protected function getQueueOrderBy()
    {
        $queues = $this->getQueueIds();
        $orderBy = "FIELD(dst, ";

        foreach ($queues as $index => $queue) {
            $orderBy .= "'" . $queue . "'";
            if ($index < count($queues) - 1) {
                $orderBy .= ", ";
            }
        }

        $orderBy .= ") ASC";
        return $orderBy;
    }


    protected function generateWeeklyReport($startDate, $endDate)
    {
        $this->reportData = CallDetailsRecordModel::query()
            ->select(
                DB::raw('DATE(calldate) as label'),
                DB::raw('count(*) as total_calls'),
                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
                DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
                DB::raw('avg(duration) as avg_duration'),
                DB::raw('avg(wait_time) as avg_wait_time'),
                DB::raw('avg(talk_time) as avg_talk_time'),
                DB::raw('max(wait_time) as max_wait_time'),
                DB::raw('HOUR(calldate) as hour'),
                DB::raw('count(case when wait_time <= 20 then 1 else null end) as sla_compliant')
            )
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereIn('dst', $this->getQueueIds())
            ->groupBy(DB::raw('DATE(calldate)'))
            ->orderBy('label')
            ->get()
            ->map(function ($item) {
                $item->sla_compliance = $item->total_calls > 0
                    ? round(($item->sla_compliant / $item->total_calls) * 100, 2)
                    : 0;
                return $item;
            })
            ->toArray();
    }

//    protected function generateAgentPerformanceReport($startDate, $endDate)
//    {
//        $this->reportData = CallDetailsRecordModel::query()
//            ->select(
//                'agent_id as label',
//                DB::raw('count(*) as total_calls'),
//                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
//                DB::raw('avg(talk_time) as avg_talk_time'),
//                DB::raw('avg(hold_time) as avg_hold_time'),
//                DB::raw('sum(case when disposition = "ANSWERED" and duration > 0 then 1 else 0 end) as first_call_resolution'),
//                DB::raw('avg(satisfaction) as satisfaction'),
//                DB::raw('avg(wrap_up_time) as wrap_up_time')
//            )
//            ->whereBetween('calldate', [$startDate, $endDate])
//            ->whereNotNull('agent_id')
//            ->when($this->selectedAgent, function ($query) {
//                $query->where('agent_id', $this->selectedAgent);
//            })
//            ->groupBy('agent_id')
//            ->orderBy('total_calls', 'desc')
//            ->get()
//            ->map(function ($item) {
//                $item->first_call_resolution = $item->answered > 0
//                    ? round(($item->first_call_resolution / $item->answered) * 100, 2)
//                    : 0;
//                return $item;
//            })
//            ->toArray();
//    }

    protected function generateAgentPerformanceReport($startDate, $endDate)
    {
        // Step 1: Get dst per agent_id via CCAgent
        $agentDstMap = \App\Models\Live\CCAgent::pluck('endpoint', 'id')->toArray(); // agent_id => dst

        // Step 2: Get call performance
        dd($results = CallDetailsRecordModel::query()
            ->select(
                'agent_id as label',
                DB::raw('COUNT(*) as total_calls'),
                DB::raw('SUM(CASE WHEN disposition = "ANSWERED" THEN 1 ELSE 0 END) as answered'),
                DB::raw('AVG(talk_time) as avg_talk_time'),
                DB::raw('AVG(hold_time) as avg_hold_time'),
                DB::raw('SUM(CASE WHEN disposition = "ANSWERED" AND duration > 0 THEN 1 ELSE 0 END) as first_call_resolution'),
                DB::raw('AVG(satisfaction) as satisfaction'),
                DB::raw('AVG(wrap_up_time) as wrap_up_time')
            )
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereNotNull('agent_id')
            ->when($this->selectedAgent, fn($q) => $q->where('agent_id', $this->selectedAgent))
            ->groupBy('agent_id')
            ->orderByDesc('total_calls')
            ->get());

        // Step 3: Count how many calls were made per dst
        $dstCounts = CallDetailsRecordModel::query()
            ->select('dst', DB::raw('COUNT(*) as dst_call_count'))
            ->whereBetween('calldate', [$startDate, $endDate])
            ->groupBy('dst')
            ->pluck('dst_call_count', 'dst')
            ->toArray();

        // Step 4: Attach dst count and FCR percentage
        $this->reportData = $results->map(function ($item) use ($agentDstMap, $dstCounts) {
            $item->first_call_resolution = $item->answered > 0
                ? round(($item->first_call_resolution / $item->answered) * 100, 2)
                : 0;

            $dst = $agentDstMap[$item->label] ?? null;
            $item->dst_call_count = $dst ? ($dstCounts[$dst] ?? 0) : 0;

            return $item;
        })->toArray();
    }



    protected function generateQueuePerformanceReport($startDate, $endDate)
    {
        $this->reportData = CallDetailsRecordModel::query()
            ->select(
                'dst as label',
                DB::raw('count(*) as total_calls'),
                DB::raw('sum(case when disposition = "ANSWERED" then 1 else 0 end) as answered'),
                DB::raw('sum(case when disposition = "ABANDONED" then 1 else 0 end) as abandoned'),
                DB::raw('avg(wait_time) as avg_wait_time'),
                DB::raw('max(wait_time) as max_wait_time'),
                DB::raw('count(case when wait_time <= 20 then 1 else null end) as sla_compliant')
            )
            ->whereBetween('calldate', [$startDate, $endDate])
            ->whereIn('dst', $this->queueIds ?: $this->getQueueIds())
            ->groupBy('dst')
            ->orderBy('total_calls', 'desc')
            ->get()
            ->map(function ($item) {
                $item->abandon_rate = $item->total_calls > 0
                    ? round(($item->abandoned / $item->total_calls) * 100, 2)
                    : 0;
                $item->sla_compliance = $item->total_calls > 0
                    ? round(($item->sla_compliant / $item->total_calls) * 100, 2)
                    : 0;
                return $item;
            })
            ->toArray();
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
            'cc-3', 'cc-7', 'cc-13', 'cc-15', 'cc-20', 'cc-6', 'cc-18',
            'cc-4', 'cc-14', 'cc-8', 'cc-9', 'cc-10', 'cc-11', 'cc-12',
            'cc-16', 'cc-17', 'cc-21'
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

        return view('livewire.general-report');

    }
}

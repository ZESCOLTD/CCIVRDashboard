{{-- REPORT MODULE START --}}
<div class="row">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-orange text-white">
                <h2><i class="fas fa-file-export mr-2"></i>Report Management Dashboard</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Generate Report Section -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6>Generate Report</h6>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="generateReport">
                                    @csrf
                                    <div class="form-group">
                                        <label for="reportType">Report Type</label>
                                        <select class="form-control" wire:model="reportType" id="reportType" required>
                                            <option value="">-- Select Report --</option>
                                            <option value="daily">Daily Summary</option>
                                            <option value="weekly">Weekly Summary</option>
                                            <option value="agent">Agent Performance</option>
                                            <option value="queue">Queue Performance</option>
                                            <option value="sms">SMS Broadcast Report</option>
                                            <option value="transaction">Transaction Codes statistics</option>
                                            <option value="sms">SMS Broadcast Report</option>
                                        </select>
                                    </div>

                                    <!-- Agent Filter (Optional) -->
{{--                                    @if($reportType === 'agent')--}}
{{--                                        <div class="form-group" wire:ignore>--}}
{{--                                            <label for="selectedAgent">Filter by Agent (Optional)</label>--}}
{{--                                            <select class="form-control" id="selectedAgent">--}}
{{--                                                <option value="">-- All Agents --</option>--}}
{{--                                                @foreach($agents as $agent)--}}
{{--                                                    <option value="{{ $agent->id }}" {{ $selectedAgent == $agent->id ? 'selected' : '' }}>--}}
{{--                                                        {{ $agent->name }}--}}
{{--                                                    </option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}

                                    @if($reportType === 'agent')
                                        <div class="form-group">
                                            <label for="selectedAgent">Filter by Agent (Optional)</label>
                                            <select class="form-control" id="selectedAgent" wire:model.defer="selectedAgent">
                                                <option value="">-- All Agents --</option>
                                                @foreach($agents as $agent)
                                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif

                                    <!-- Date Range -->
                                    <div class="form-group">
                                        <label for="startDate">Date Range</label>
                                        <div class="input-group">
{{--                                            <input type="date" class="form-control" wire:model.defer="startDate" id="startDate">--}}
                                            <input type="date" wire:model.defer="startDate" class="form-control" id="startDate">
                                            <div class="input-group-append">
                                                <span class="input-group-text">to</span>
                                            </div>
{{--                                            <input type="date" class="form-control" wire:model.defer="endDate" id="endDate">--}}
                                            <input type="date" wire:model.defer="endDate" class="form-control" id="endDate">
                                        </div>
                                    </div>

                                    <!-- Time Range -->
                                    <div class="form-group" id="timeRangeGroup">
                                        <label for="startTime">Time Range (Optional)</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" wire:model.defer="startTime" id="startTime">
                                            <div class="input-group-append">
                                                <span class="input-group-text">to</span>
                                            </div>
                                            <input type="time" class="form-control" wire:model.defer="endTime" id="endTime">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-success flex-fill"
                                                        data-toggle="modal"
                                                        wire:click="generateReport"
                                                        data-target="#{{ $reportType }}Modal">
                                                    <i class="fas fa-sync-alt mr-2"></i> Generate Report
                                                </button>

                                                <button type="button" class="btn btn-warning flex-fill"
                                                        wire:click="resetSearch">
                                                    <i class="fas fa-undo mr-2"></i> Reset Search
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Export Options Section -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6>Export Options</h6>
                            </div>
                            <div class="card-body text-center">
                                <button class="btn btn-outline-success mb-2 btn-block" wire:click="exportToExcel"
                                        @if(!$reportData) disabled @endif>
                                    <i class="fas fa-file-excel mr-2"></i> Export to Excel
                                </button>
                                <button class="btn btn-outline-info mb-2 btn-block" wire:click="exportToCSV"
                                        @if(!$reportData) disabled @endif>
                                    <i class="fas fa-file-csv mr-2"></i> Export to CSV
                                </button>
                                <button class="btn btn-outline-danger mb-2 btn-block" wire:click="exportToPDF"
                                        @if(!$reportData) disabled @endif>
                                    <i class="fas fa-file-pdf mr-2"></i> Export to PDF
                                </button>
                                <button class="btn btn-outline-secondary btn-block" wire:click="showEmailModal"
                                        @if(!$reportData) disabled @endif>
                                    <i class="fas fa-envelope mr-2"></i> Email Report
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Automated Reports Section -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6>Automated Reports</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="dailyReportSwitch"
                                               wire:model="autoDaily">
                                        <label class="custom-control-label" for="dailyReportSwitch">Daily Summary</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="weeklyReportSwitch"
                                               wire:model="autoWeekly">
                                        <label class="custom-control-label" for="weeklyReportSwitch">Weekly Summary</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reportRecipients">Recipients</label>
                                    <input type="text" class="form-control" wire:model="recipients"
                                           id="reportRecipients" value="managers@company.com, supervisors@company.com">
                                </div>
                                <button type="button" class="btn btn-info btn-block" wire:click="saveAutomatedSettings">
                                    <i class="fas fa-save mr-2"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Display Section -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card" id="reportResultsCard" style="@if(!$reportData) display:none; @endif">
                            <div class="card-header bg-orange text-white">
                                <h5 id="reportTitle">{{ $reportTitle ?? 'Report Results' }}</h5>
                                <div class="card-tools">
                                    <span class="badge badge-light" id="reportDateRange">{{ $dateRange ?? '' }}</span>
                                    <button type="button" class="btn btn-tool" id="viewFullReportBtn"
                                            data-toggle="modal" data-target="#{{ $reportType }}Modal">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" id="printReportBtn">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="reportResultsBody">
                                <div wire:loading class="text-center py-5">
                                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                                    <p>Generating report...</p>
                                </div>

                                <div wire:loading.remove>
{{--                                    @if(!empty($reportData)) <!-- Check if array is not empty -->--}}
                                    @if(!empty($reportData) && is_array($reportData))
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <table id="reportTable" class="table table-striped">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>{{ $reportType === 'weekly' ? 'Day' : ($reportType === 'agent' ? 'Agent' : ($reportType === 'queue' ? 'Queue' : 'Time')) }}</th>
                                                <th>Total Calls</th>
                                                <th>Answered</th>
                                                <th>Abandoned</th>
                                                <th>Avg Duration</th>
                                                @if($reportType === 'agent')
                                                    <th>Satisfaction</th>
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reportData as $item) <!-- Directly loop over array -->
                                            <tr>
{{--                                                <td>{{ $item['label'] }}: {{ $item['agent_name'] }}</td> <!-- Access as array -->--}}
                                                <td>{{ $item['label'] }}: {{ $item['agent_name'] ?? 'N/A' }}</td>

                                                <td>{{ $item['total_calls'] }}</td>
                                                <td>{{ $item['answered'] ?? 'N/A' }}</td>
                                                <td>{{ $item['abandoned'] ?? 'N/A' }}</td>
                                                <td>{{ $item['avg_duration'] ?? 'N/A' }}</td>
                                                @if($reportType === 'agent')
                                                    @php
                                                        $satisfaction = $item['satisfaction'] ?? null;
                                                        if ($satisfaction >= 90) {
                                                            $color = 'green';
                                                        } elseif ($satisfaction >= 75) {
                                                            $color = 'green';
                                                        } elseif ($satisfaction >= 50) {
                                                            $color = 'orange';
                                                        } else {
                                                            $color = 'red';
                                                        }
                                                    @endphp

                                                    <td style="color: {{ $satisfaction !== null ? $color : 'black' }}">
                                                        {{ $satisfaction !== null ? $satisfaction . '%' : 'N/A' }}
                                                    </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                        <div class="alert alert-info">
                                            No report data available. Please generate a report.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card" id="reportResultsCard" style="@if(!$reportData) display:none; @endif">
            <div class="card-header bg-orange text-white d-flex justify-content-between align-items-center">
                <h5 id="reportTitle">{{ $reportTitle ?? 'Agent Performance Report' }}</h5>
                <div class="card-tools d-flex align-items-center gap-2">
                    <span class="badge badge-light mr-2" id="reportDateRange">{{ $dateRange ?? '' }}</span>
                    <button type="button" class="btn btn-tool" id="viewFullReportBtn"
                            data-toggle="modal" data-target="#{{ $reportType }}Modal">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="window.print()">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>

            <div class="card-body" id="reportResultsBody">
                <div wire:loading class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-3x"></i>
                    <p>Generating report...</p>
                </div>

                <div wire:loading.remove>
                    @if(!empty($reportData) && is_array($reportData))
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Agent111</th>
                                    <th>Total Calls</th>
                                    <th>Calls Received (by Number)</th>
                                    <th>Avg Talk Time</th>
                                    <th>Avg Hold Time</th>
                                    <th>First Call Res</th>
                                    <th>Satisfaction</th>
                                    <th>Wrap Up Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($reportData as $item)
                                    <tr>
{{--                                        <td>{{ $item['label'] }}:{{ $item['agent_name'] }}</td>--}}
                                        <td>{{ $item['label'] }}: {{ $item['agent_name'] ?? 'N/A' }}</td>

                                        <td>{{ $item['total_calls'] }}</td>
                                        <td>{{ $item['dst_call_count'] ?? 0 }}</td>
                                        <td>{{ $item['avg_talk_time'] ?? 'N/A' }}</td>
                                        <td>{{ $item['avg_hold_time'] ?? 'N/A' }}</td>
                                        <td>{{ $item['first_call_resolution'] ?? 'N/A' }}%</td>
                                        <td>{{ $item['satisfaction'] ?? 'N/A' }}%</td>
                                        <td>{{ $item['wrap_up_time'] ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No agent performance data available. Please generate a report.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Weekly Report Modal -->
<div class="modal fade" id="weeklyModal" tabindex="-1" role="dialog" aria-labelledby="weeklyModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="weeklyModalLabel">Weekly Report - Week of {{ $startDate ?? '' }}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($reportData && $reportType === 'weekly')
                    <div wire:loading wire:target="generateWeeklyReport" class="text-center my-3">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p>Generating report...</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="weeklyReportTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>Day</th>
                                <th>Total Calls</th>
                                <th>Answered</th>
                                <th>Abandoned</th>
                                <th>Avg Duration</th>
                                <th>Peak Hour</th>
                                <th>SLA Compliance (%)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reportData as $item)
                                <tr>
                                    <td>{{ $item['label'] }}</td>
                                    <td>{{ $item['total_calls'] }}</td>
                                    <td>{{ $item['answered'] }}</td>
                                    <td>{{ $item['abandoned'] }}</td>
                                    <td>{{ $item['avg_duration'] }}</td>
                                    <td>{{ $item['peak_hour'] }}</td>
                                    <td>{{ $item['sla_compliance'] }}%</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">No report data available.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>



<!-- Agent Performance Modal -->


<!-- Queue Performance Modal -->
<div class="modal fade" id="queueModal" tabindex="-1" role="dialog" aria-labelledby="queueModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="queueModalLabel">Queue Performance Report</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($reportData && $reportType === 'agent' && is_iterable($reportData) && count($reportData) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="agentReportTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>Agent Name (DST)</th>
                                <th>Total Calls</th>
                                <th>Answered</th>
                                <th>Abandoned</th>
                                <th>Avg Duration (s)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reportData as $item)
                                <tr>
                                    <td>{{ $item['label'] ?? $item['dst'] ?? 'N/A' }}</td>
                                    <td>{{ $item['agent_name'] ?? 'Unknown' }}</td>
                                    <td>{{ $item['total_calls'] ?? 0 }}</td>
                                    <td>{{ $item['answered'] ?? 0 }}</td>
                                    <td>{{ $item['abandoned'] ?? 0 }}</td>
                                    <td>{{ $item['avg_duration'] ?? '00:00:00' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No agent performance data available. Please generate a report.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SMS Broadcast Modal -->
<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="smsModalLabel">SMS Broadcast Report</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($reportData && $reportType === 'sms')
                    <div class="table-responsive">
                        <table class="table table-bordered" id="smsReportTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>Campaign</th>
                                <th>Messages Sent</th>
                                <th>Delivered</th>
                                <th>Failed</th>
                                <th>Delivery Rate</th>
                                <th>Response Rate</th>
                                <th>Opt Outs</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reportData as $item)
                                <tr>
                                    <td>{{ $item['label'] }}</td>
                                    <td>{{ $item['sent'] ?? 'N/A' }}</td>
                                    <td>{{ $item['delivered'] ?? 'N/A' }}</td>
                                    <td>{{ $item['failed'] ?? 'N/A' }}</td>
                                    <td>{{ $item['delivery_rate'] ?? 'N/A' }}%</td>
                                    <td>{{ $item['response_rate'] ?? 'N/A' }}%</td>
                                    <td>{{ $item['opt_outs'] ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print mr-2"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Email Modal (unchanged) -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true"  wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="emailModalLabel">Email Report</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="emailRecipients">Recipients</label>
                    <input type="text" class="form-control" wire:model="emailRecipients" id="emailRecipients">
                </div>
                <div class="form-group">
                    <label for="emailSubject">Subject</label>
                    <input type="text" class="form-control" wire:model="emailSubject" id="emailSubject">
                </div>
                <div class="form-group">
                    <label for="emailMessage">Message</label>
                    <textarea class="form-control" wire:model="emailMessage" id="emailMessage" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" wire:click="sendEmail">
                    <i class="fas fa-paper-plane mr-2"></i> Send
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        #reportLoading p {
            margin-top: 15px;
            font-size: 18px;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #007bff;
        }

        #detailedReportTable th {
            white-space: nowrap;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
{{--    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>--}}


@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function () {
            // Initialize DataTables when modals open
            $('.modal').on('shown.bs.modal', function () {
                const tableId = $(this).find('table').attr('id');
                if (tableId) {
                    $('#' + tableId).DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'csv', 'excel', 'pdf', 'print'
                        ],
                        responsive: true,
                        pageLength: 10
                    });
                }
            });

            // Destroy DataTables when modals close
            $('.modal').on('hidden.bs.modal', function () {
                const table = $(this).find('table').DataTable();
                if (table) {
                    table.destroy();
                }
            });

            // Print button handler
            $('#printReportBtn').click(function () {
                window.print();
            });

            // Handle report type change to show/hide time range
            $('#reportType').change(function() {
                const type = $(this).val();
                if (type === 'daily') {
                    $('#timeRangeGroup').show();
                } else {
                    $('#timeRangeGroup').hide();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:load', function () {
            function initTomSelect() {
                const select = document.getElementById('selectedAgent');
                if (select && !select.tomselect) {
                    const ts = new TomSelect(select, {
                        create: false,
                        allowEmptyOption: true,
                        placeholder: "Select an Agent"
                    });

                    select.addEventListener('change', function (e) {
                        @this.set('selectedAgent', e.target.value);
                    });
                }
            }

            initTomSelect(); // Initial load

            Livewire.hook('message.processed', (message, component) => {
                initTomSelect(); // Re-init after Livewire DOM update
            });
        });
    </script>

{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#reportTable').DataTable({--}}
{{--                pageLength: 10,--}}
{{--                lengthMenu: [5, 10, 25, 50],--}}
{{--                ordering: true,--}}
{{--                language: {--}}
{{--                    search: "Search Table:",--}}
{{--                    lengthMenu: "Show _MENU_ entries"--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}


@endpush
{{-- REPORT MODULE END --}}


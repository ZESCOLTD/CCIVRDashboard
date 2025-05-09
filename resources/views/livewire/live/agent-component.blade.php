<div>
    <div class="row">
        <div class="col">
            <!-- Agent Information and Status -->
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-orange text-white">
                    <h5 class="mb-0"><i class="fas fa-user-tie mr-2"></i>Agent Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Agent Information -->
                        <div class="col-md-4 border-right">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-green-light text-orange mr-3">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Agent Information</h5>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-user mr-2 text-secondary"></i>
                                    <strong>Name:</strong> {{ $agent->name }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-id-card mr-2 text-secondary"></i>
                                    <strong>ID:</strong> {{ $agent->endpoint }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-phone mr-2 text-secondary"></i>
                                    <strong>Number:</strong> {{ $agent->endpoint }}
                                </li>
                                <li>
                                    <i class="fas fa-power-off mr-2 text-secondary"></i>
                                    <strong>Status:</strong>
                                    @switch($agent->status)
                                        @case('LOGGED_IN')
                                        @case('AgentState.LOGGEDIN')
                                            <span class="badge badge-success"><i class="fas fa-circle mr-1"></i>LOGGED IN</span>
                                        @break

                                        @case('LOGGED_OUT')
                                        @case('AgentState.LOGGEDOUT')
                                            <span class="badge badge-secondary"><i class="fas fa-circle mr-1"></i>LOGGED
                                                OUT</span>
                                        @break

                                        @case('IDLE')
                                        @case('AgentState.IDLE')
                                            <span class="badge badge-warning text-dark"><i
                                                    class="fas fa-circle mr-1"></i>IDLE</span>
                                        @break

                                        @case('WITHDRAWN')
                                        @case('AgentState.WITHDRAWN')
                                            <span class="badge badge-danger"><i class="fas fa-circle mr-1"></i>WITHDRAWN</span>
                                        @break

                                        @case('WRAPPING_UP')
                                        @case('AgentState.WRAPPINGUP')

                                        @case('ON_BREAK')
                                            <span class="badge badge-info"><i class="fas fa-circle mr-1"></i>ON BREAK</span>
                                        @break

                                        @case('IN_CONVERSATION')
                                        @case('AgentState.ONCONVERSATION')
                                            <span class="badge badge-primary"><i class="fas fa-circle mr-1"></i>IN
                                                CONVERSATION</span>
                                        @break

                                        @default
                                            <span class="badge badge-light text-dark"><i
                                                    class="fas fa-circle mr-1"></i>{{ $agent->status }}</span>
                                    @endswitch
                                </li>
                            </ul>
                        </div>

                        <!-- Session Information -->
                        <div class="col-md-4 border-right">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary-light text-orange mr-3">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Session Info</h5>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-info small d-flex align-items-center">
                                    <i class="fas fa-plug mr-2"></i>Recorder Websocket:
                                    <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                                    <span id="ws-info" wire:ignore class="badge badge-info ml-2">Connecting...</span>
                                </label>
                            </div>
                            <div>
                                <strong class="d-flex align-items-center">
                                    <i class="fas fa-clock mr-2"></i>Current Session:
                                </strong>
                                @if ($currentSession)
                                    <div class="d-flex align-items-center mt-1 mb-2">
                                        <span class="badge badge-primary mr-2">{{ $currentSession->name }}</span>
                                        <button class="btn btn-sm btn-outline-primary" data-toggle="modal"
                                            data-target="#sessionModal">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                    <div class="small">
                                        <div><i class="far fa-clock mr-2"></i>From: {{ $currentSession->time_from }}
                                        </div>
                                        <div><i class="far fa-clock mr-2"></i>To: {{ $currentSession->time_to }}</div>
                                    </div>
                                @else
                                    <div class="alert alert-warning py-1 px-2 mt-2 small">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>No session selected
                                    </div>
                                    {{-- <script>

                                        document.addEventListener('DOMContentLoaded', function () {
                                            var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                                            sessionModal.show();
                                        });

                                                                           </script> --}}
                                @endif
                            </div>
                        </div>

                        <!-- Current Call -->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary-light text-orange mr-3">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Current Call</h5>
                                </div>
                            </div>
                            <div class="call-info">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user-circle mr-2 text-secondary"></i>
                                    <strong>Caller ID:</strong>
                                    <span class="ml-2 text-info" id="incoming-call">+1234567890</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-stopwatch mr-2 text-secondary"></i>
                                    <strong>Duration:</strong>
                                    <span class="ml-2">00:03:15</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-stopwatch mr-2 text-secondary"></i>
                                    <strong>Calls in Queue:</strong>
                                    <h3 id="queue-calls" wire:ignore class="ml-2">0</h3>
                                </div>

                                @if ($agent && $agent->status === config('constants.agent_status.ON_BREAK'))
                                    <div wire:poll.1s="calculateTotalBreakDurationForToday">
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="fas fa-stopwatch mr-2 text-danger font-weight-bold h4"></i>
                                            <strong class="text-danger h5">Total Break Time:</strong>
                                            <span class="ml-2 font-weight-bold text-danger h5">
                                                {{ $totalBreakDuration }}
                                            </span>
                                        </div>

                                        {{-- <div wire:poll.60s="calculateTotalBreakDuration">
                                            Break Duration: {{ $breakDuration }}
                                        </div> --}}

                                        @if ($breakLimitReached)
                                            <div class="text-danger font-weight-bold text-center mt-2">
                                                ⚠️ Total break time exceeded 40 minutes for this shift.
                                            </div>
                                        @endif
                                    </div>
                                @endif



                                <div class="mt-3">
                                    @if (in_array($agent->status, ['LOGGED_OUT', 'WITHDRAWN']))
                                        <form wire:submit.prevent="login">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <i class="fas fa-sign-in-alt mr-1"></i> Login
                                            </button>
                                        </form>
                                    @else
                                        <div class="d-flex">
                                            <form
                                                wire:submit.prevent="{{ $agent->status == 'ON_BREAK' ? 'resume' : 'break' }}"
                                                class="mr-2 flex-fill">
                                                <button type="submit"
                                                    class="btn {{ $agent->status == 'ON_BREAK' ? 'btn-info' : 'btn-secondary' }} btn-block">
                                                    <i class="fas fa-coffee mr-1"></i>
                                                    {{ $agent->status == 'ON_BREAK' ? 'Resume' : 'Break' }}
                                                </button>
                                            </form>

                                            <form wire:submit.prevent="logout" class="flex-fill">
                                                <button type="submit" class="btn btn-warning btn-block">
                                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                                </button>
                                            </form>
                                        </div>

                                        {{-- @if ($onBreak && $breakStartTime)
                                            <div class="mt-2 text-center text-info font-weight-bold">
                                                <small>On break for {{ $breakMinutes }} minute(s)</small>
                                            </div>
                                        @endif --}}
                                    @endif
                                </div>

                                <div x-data x-init="setInterval(() => Livewire.emit('refreshComponent'), 60000)"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Overview -->
            <div class="row">
                <!-- Total Calls Card -->
                <div class="col-md-3 mb-4">
                    <div class="stats-card bg-primary-light">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Total Calls</h6>
                            <h3>{{ $totalCalls }}</h3>
                            <div class="trend up">
                                <i class="fas fa-arrow-up"></i> 12% <span class="trend-text">vs yesterday</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Answered Calls Card -->
                <div class="col-md-3 mb-4">
                    <div class="stats-card bg-success-light">
                        <div class="icon-circle bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Answered Calls</h6>
                            <h3>{{ $answeredCalls }}</h3>
                            <div class="trend up">
                                <i class="fas fa-arrow-up"></i> 8% <span class="trend-text">vs yesterday</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Missed Calls Card -->
                <div class="col-md-3 mb-4">
                    <div class="stats-card bg-danger-light">
                        <div class="icon-circle bg-danger">
                            <i class="fas fa-times"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Missed Calls</h6>
                            <h3>{{ $missedCalls }}</h3>
                            <div class="trend down">
                                <i class="fas fa-arrow-down"></i> 5% <span class="trend-text">vs yesterday</span>
                            </div>
                        </div>
                    </div>
                </div>
                <style>
                    :root {
                        --primary-color: #f39c35;
                        --primary-light: rgba(243, 156, 53, 0.1);
                        --secondary-color: #14944c;
                    }

                    .card {
                        border-radius: 10px;
                        overflow: hidden;
                        border: none;
                    }

                    .card-header {
                        padding: 1rem 1.5rem;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                    }

                    .icon-circle {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 1.2rem;
                    }

                    .bg-primary-light {
                        background-color: var(--primary-light);
                    }

                    .badge {
                        padding: 5px 10px;
                        font-weight: 500;
                        letter-spacing: 0.5px;
                    }

                    .btn-primary {
                        background-color: var(--primary-color);
                        border-color: var(--primary-color);
                    }

                    .btn-primary:hover {
                        background-color: #e08a2a;
                        border-color: #e08a2a;
                    }

                    .btn-outline-primary {
                        color: var(--primary-color);
                        border-color: var(--primary-color);
                    }

                    .btn-outline-primary:hover {
                        background-color: var(--primary-color);
                        border-color: var(--primary-color);
                    }

                    .btn-secondary {
                        background-color: var(--secondary-color);
                        border-color: var(--secondary-color);
                    }

                    .btn-secondary:hover {
                        background-color: #11823f;
                        border-color: #11823f;
                    }

                    .shadow-sm {
                        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
                    }

                    .border-end {
                        border-right: 1px solid #dee2e6 !important;
                    }

                    :root {
                        --primary-color: #f39c35;
                        --primary-light: rgba(243, 156, 53, 0.1);
                        --success-color: #28a745;
                        --success-light: rgba(40, 167, 69, 0.1);
                        --danger-color: #dc3545;
                        --danger-light: rgba(220, 53, 69, 0.1);
                        --warning-color: #ffc107;
                        --warning-light: rgba(255, 193, 7, 0.1);
                    }

                    .stats-card {
                        border-radius: 10px;
                        padding: 20px;
                        display: flex;
                        align-items: center;
                        height: 100%;
                        transition: transform 0.3s ease;
                        border: 1px solid rgba(0, 0, 0, 0.05);
                    }

                    .stats-card:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                    }

                    .icon-circle {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: white;
                        font-size: 1.25rem;
                        margin-right: 15px;
                        flex-shrink: 0;
                    }

                    .stats-content {
                        flex: 1;
                    }

                    .stats-content h6 {
                        font-size: 0.85rem;
                        color: #6c757d;
                        margin-bottom: 5px;
                        font-weight: 600;
                    }

                    .stats-content h3 {
                        font-size: 1.75rem;
                        margin-bottom: 5px;
                        color: #343a40;
                        font-weight: 700;
                    }

                    .trend {
                        font-size: 0.75rem;
                        font-weight: 600;
                        display: flex;
                        align-items: center;
                    }

                    .trend i {
                        margin-right: 3px;
                        font-size: 0.65rem;
                    }

                    .trend.up {
                        color: var(--success-color);
                    }

                    .trend.down {
                        color: var(--danger-color);
                    }

                    .trend-text {
                        color: #6c757d;
                        font-weight: 400;
                        margin-left: 5px;
                        font-size: 0.65rem;
                    }

                    .bg-primary-light {
                        background-color: var(--primary-light);
                    }

                    .bg-success-light {
                        background-color: var(--success-light);
                    }

                    .bg-danger-light {
                        background-color: var(--danger-light);
                    }

                    .bg-warning-light {
                        background-color: var(--warning-light);
                    }

                    .bg-primary {
                        background-color: var(--primary-color);
                    }

                    .bg-success {
                        background-color: var(--success-color);
                    }

                    .bg-danger {
                        background-color: var(--danger-color);
                    }

                    .bg-warning {
                        background-color: var(--warning-color);
                    }
                </style>
                <!-- Average Call Time Card -->
                <div class="col-md-3 mb-4">
                    <div class="stats-card bg-warning-light">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Avg. Call Time</h6>
                            <h3>{{ $averageCallTime }}</h3>
                            <div class="trend up">
                                <i class="fas fa-arrow-up"></i> 2% <span class="trend-text">vs yesterday</span>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <style>
                .search-suggestions {
                    max-height: 300px;
                    overflow-y: auto;
                    z-index: 1000;
                    border: 1px solid #ddd;
                }

                .search-suggestions .list-group-item {
                    border-left: none;
                    border-right: none;
                }

                .search-suggestions .list-group-item:hover {
                    background-color: #f8f9fa;
                }

                .knowledge-content {
                    max-height: 400px;
                    overflow-y: auto;
                    background-color: #f8f9fa;
                }

                .z-index-100 {
                    z-index: 100;
                }

                /* Search Container */
                .search-container {
                    position: relative;
                    z-index: 100;
                }

                .search-results {
                    position: absolute;
                    width: 100%;
                    max-height: 300px;
                    overflow-y: auto;
                    background: white;
                    border-radius: 8px;
                    z-index: 1050;
                    border: 1px solid rgba(0, 0, 0, 0.1);
                }

                .search-results .list-group-item {
                    border-left: none;
                    border-right: none;
                    transition: all 0.2s;
                }

                .search-results .list-group-item:hover {
                    background-color: #f8f9fa;
                }

                .search-results .list-group-item:first-child {
                    border-top: none;
                    border-top-left-radius: 0;
                    border-top-right-radius: 0;
                }

                .search-results .list-group-item:last-child {
                    border-bottom-left-radius: 0;
                    border-bottom-right-radius: 0;
                }

                /* Modal Styles */
                .modal-content {
                    border-radius: 10px;
                    overflow: hidden;
                }

                .knowledge-content {
                    line-height: 1.6;
                }

                .knowledge-content h4,
                .knowledge-content h5 {
                    color: var(--primary-color);
                    margin-top: 1.5rem;
                }

                .knowledge-content ul,
                .knowledge-content ol {
                    padding-left: 1.5rem;
                }

                .knowledge-content pre {
                    background: #f8f9fa;
                    padding: 1rem;
                    border-radius: 5px;
                    overflow-x: auto;
                }

                .knowledge-content code {
                    background: #f8f9fa;
                    padding: 0.2rem 0.4rem;
                    border-radius: 3px;
                    font-size: 0.9em;
                }

                /* Corporate Colors */
                .bg-primary {
                    background-color: #f39c35 !important;
                    border-color: #f39c35 !important;
                }

                .btn-primary {
                    background-color: #f39c35;
                    border-color: #f39c35;
                }

                .btn-primary:hover {
                    background-color: #e08a2a;
                    border-color: #e08a2a;
                }

                .btn-success {
                    background-color: #14944c;
                    border-color: #14944c;
                }

                /* Responsive Adjustments */
                @media (max-width: 768px) {
                    .search-results {
                        max-height: 250px;
                    }

                    .modal-dialog {
                        margin: 1rem;
                    }
                }

                /* Customer Card Styles */
                .customer-profile {
                    background-color: #fff;
                    border-radius: 8px;
                    padding: 20px;
                }

                .avatar {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.5rem;
                    font-weight: bold;
                }

                .info-section {
                    background-color: #f8f9fa;
                    border-radius: 8px;
                    padding: 15px;
                    margin-bottom: 15px;
                }

                .section-title {
                    color: #f39c35;
                    font-size: 0.9rem;
                    margin-bottom: 10px;
                    border-bottom: 1px solid #dee2e6;
                    padding-bottom: 5px;
                }

                .empty-state {
                    color: #6c757d;
                }

                /* Modal Styles */
                .modal-xl .modal-body {
                    padding: 0;
                }

                .modal-xl .table {
                    margin-bottom: 0;
                }

                .modal-xl .table th {
                    background-color: #f8f9fa;
                }

                /* Search Box */
                .search-box .input-group-sm .form-control {
                    height: calc(1.5em + 0.5rem + 2px);
                    padding: 0.25rem 0.5rem;
                    font-size: 0.875rem;
                }

                /* Corporate Colors */
                .bg-primary {
                    background-color: #f39c35 !important;
                    border-color: #f39c35 !important;
                }

                .btn-primary {
                    background-color: #f39c35;
                    border-color: #f39c35;
                }

                .btn-primary:hover {
                    background-color: #e08a2a;
                    border-color: #e08a2a;
                }
            </style>
            <!-- Knowledge Base Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-orange text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-book me-2"></i>Agent Knowledge Base</h5>
                        <small class="text-white-50">Type your topic of interest</small>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Search Section -->
                    <div class="search-container position-relative mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0"
                                wire:model.debounce.300ms="searchQuery"
                                placeholder="Search knowledge base (e.g., billing, payments, technical issues)..."
                                autocomplete="off" aria-label="Knowledge base search">
                        </div>

                        @if (!empty($searchResults))
                            <div class="search-results shadow-lg mt-1">
                                <div class="list-group">
                                    @foreach ($searchResults as $result)
                                        <a href="#" class="list-group-item list-group-item-action py-3"
                                            wire:click="selectTopic({{ $result['id'] }})" data-toggle="modal"
                                            data-target="#technicalModal">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1 text-primary">{{ $result['topic'] }}</h6>
                                                <small class="text-muted">Click to view</small>
                                            </div>
                                            <p class="mb-1 text-muted small">
                                                {{ Str::limit($result['description'], 120) }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @elseif(!empty($searchQuery))
                            <div class="search-results shadow-lg mt-1">
                                <div class="p-3 text-center">
                                    <i class="fas fa-search fa-2x text-muted mb-2"></i>
                                    <p class="mb-0">No results found for <strong>"{{ $searchQuery }}"</strong></p>
                                    <small class="text-muted">Try different keywords</small>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Access Categories -->
                    @if (!empty($popularTopics))
                        @foreach ($popularTopics as $popularTopic)
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-star me-1"></i> {{ $popularTopic->topic }}
                            </button>
                        @endforeach
                    @else
                        <p>No popular topics found.</p>
                    @endif


                </div>
            </div>
            <!-- Knowledge Modal -->
            <div class="modal fade" id="technicalModal" tabindex="-1" aria-labelledby="technicalModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow">
                        @if ($selectedTopic)
                            <div class="modal-header bg-primary text-white">
                                <div>
                                    <h5 class="modal-title" id="technicalModalLabel">
                                        <i class="fas fa-file-alt me-2"></i>{{ $selectedTopic->topic }}
                                    </h5>
                                    <small class="text-white-50">Last updated:
                                        {{ $selectedTopic->updated_at->format('M d, Y') }}</small>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                                    aria-label="Close" wire:click="$set('selectedTopic', null)"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="technical-content formatted-content">
                                    {!! $selectedTopic->description !!}
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times me-1"></i> Close
                                </button>
                                <button type="button" class="btn btn-primary">
                                    <i class="fas fa-print me-1"></i> Print
                                </button>
                                <button type="button" class="btn btn-success">
                                    <i class="fas fa-thumbs-up me-1"></i> Helpful
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>


            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-orange text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-search me-2"></i>Customer Details Search</h5>
                        <small class="text-white-50">Search by Meter Serial, Service No, or Complaint No</small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter search term..."
                            wire:model.defer="search_term">
                        <button class="btn btn-primary d-flex align-items-center" wire:click="searchCustomers"
                            type="button">
                            <span wire:loading.remove wire:target="searchCustomers">
                                Search
                            </span>
                            <div wire:loading wire:target="searchCustomers"
                                class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true">
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="complaintsTableModal" tabindex="-1"
                aria-labelledby="complaintsTableModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="complaintsTableModalLabel">
                                <i class="fas fa-list me-2"></i> Customer Complaints Table
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($customer_details && $customer_details->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Customer Name</th>
                                                <th>Complaint No</th>
                                                <th>Meter #</th>
                                                <th>Meter Make</th>
                                                <th>Landmark</th>
                                                <th>Phone</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customer_details as $c)
                                                <tr>
                                                    <td>{{ $c->customer_name ?? '--' }}</td>
                                                    <td>{{ $c->complaint_no ?? '--' }}</td>
                                                    <td>{{ $c->meter_serial_no ?? '--' }}</td>
                                                    <td>{{ $c->meter_make ?? '--' }}</td>
                                                    <td>{{ $c->landmark ?? '--' }}</td>
                                                    <td>{{ $c->phone_number ?? '--' }}</td>
                                                    <td>{{ $c->complaint_type_desc ?? '--' }}</td>
                                                    <td>{{ $c->complaint_status_desc ?? '--' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                                    <p>No complaint data found for the given search.</p>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                wire:click="clearCustomerDetailsSession">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <div class="col-lg-4">
            <div class="card">

                <iframe id="myIframe" src="{{ url('phone') }}"width="100%" height="800"></iframe>
            </div>


        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="updateTransactionCodeModal" tabindex="-1" role="dialog"
        aria-labelledby="updateTransactionCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTransactionCodeModalLabel">Update Transaction Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>×</span>
                    </button>
                </div>
                <form wire:submit.prevent="editTCode">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="transactionCode" class="form-label">Transaction Code</label>
                            <select id="transactionCode" class="form-control" required wire:model="t_code">
                                <option value="">--Choose--</option>
                                @foreach ($transactionCodes as $transactionCode)
                                    <option value="{{ $transactionCode->code }}">{{ $transactionCode->code }} :
                                        {{ $transactionCode->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        @if (session()->has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">
                            <span wire:loading wire:target="editTCode" class="spinner-border spinner-border-sm"
                                role="status" aria-hidden="true"></span>
                            Save
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>

@push('custom-scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            console.log('[Livewire] livewire:load fired ✅');



            const iframe = document.getElementById('myIframe');
            iframe.onload = function() {
                iframe.contentWindow.postMessage({
                    man_no: {{ $agent->endpoint }}
                }, 'http://localhost:8000');
            };

        });



        document.addEventListener('show-session-modal', () => {
            console.log('[Livewire] show-session-modal fired ✅');

            const modal = new bootstrap.Modal(document.getElementById('sessionModal'));

            modal.show();

        });

        document.addEventListener('closeSessionModal', () => {
            console.log('[Livewire] closeSessionModal fired ✅');
            // const modal = bootstrap.Modal.getInstance(document.getElementById('sessionModal'));

            //     modal.hide();

        });
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            // Close modal when clicking outside
            document.getElementById('knowledgeModal').addEventListener('hidden.bs.modal', function() {
                @this.set('selectedTopic', null);
            });

            // Close search results when clicking outside
            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-container')) {
                    @this.set('searchQuery', '');
                }
            });
        });
    </script>
    <script>
        document.addEventListener('livewire:load', function() {
            // Live search on input change
            const searchInput = document.querySelector('[wire\\:model="meter_number"]');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    @this.searchCustomer();
                });
            }

            // Modal events
            const customerModal = document.getElementById('customerModal');
            customerModal.addEventListener('hidden.bs.modal', function() {
                @this.set('selectedCustomer', null);
            });

            // Listen for Livewire event to show modal
            Livewire.on('showCustomerModal', () => {
                const modal = new bootstrap.Modal(customerModal);
                modal.show();
            });
        });
    </script>
    <script defer>
        document.addEventListener('livewire:load', function() {
            Livewire.on('highlightSearch', (query) => {
                const elements = document.querySelectorAll('.search-result-text');
                elements.forEach(el => {
                    const text = el.textContent;
                    const regex = new RegExp(query, 'gi');
                    const highlighted = text.replace(regex, match =>
                        `<span class="highlight">${match}</span>`
                    );
                    el.innerHTML = highlighted;
                });
            });
        });
    </script>

    <script defer>
        Livewire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('knowledgeModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>

    <script>
        window.addEventListener('load', () => {
            const apiUrl = "http://10.44.0.70:8088/ari/bridges?api_key=asterisk:asterisk";



            function fetchHoldingBridgeData() {
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.json();
                    })
                    .then(data => {

                        // Filter bridges of type 'mixing'
                        const holdingBridges = data.filter(bridge => bridge.bridge_type === 'holding' && bridge
                            .channels.length > 0);
                        var queueCalls = 0;

                        for (let i = 0; i < holdingBridges.length; i++) {
                            queueCalls += holdingBridges[i].channels.length;
                        }

                        // Update DOM with the count (you can change this element ID)
                        document.getElementById("queue-calls").innerHTML = ` ${queueCalls}`;

                        console.log("Holding Bridges:", queueCalls);

                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    });
            }

            fetchHoldingBridgeData();
            setInterval(fetchHoldingBridgeData, 10000); // Fetch every 5 seconds


            // WebSocket connection and event listeners as in the original code

            // ws://127.0.0.1:8001/ws
            // const socket = new WebSocket("http://127.0.0.1:8001/ws");

            function reConnect() {

                var ws_address = document.getElementById("ws_endpoint");
                var ws_socket = document.getElementById("ws-info");


                const socket = new WebSocket(ws_address.value);
                socket.addEventListener("open", (event) => {
                    console.log("WebSocket connection opened: ", ws_address);
                    ws_socket.classList.remove("badge-danger");
                    ws_socket.classList.add("badge-success");
                    ws_socket.textContent = "Connected ..";
                    socket.send("Hello Server!");
                });
                socket.addEventListener("message", (event) => {
                    var data = JSON.parse(event.data);
                    fetchHoldingBridgeData();



                    if (data.type === "Dial" &&
                        data.dialstring == {{ $agent->endpoint }}
                    ) {
                        // alert( incomingCall);

                        document.getElementById("incoming-call").innerHTML = data.peer.caller.number;

                    }
                    if (data.type === "StasisEnd") {
                        //     // alert( incomingCall);
                        console.log("Incoming Call Data:", data.channel.dialplan.app_data);

                        const appData = data.channel.dialplan.app_data;
                        const parts = appData.split(',');


                        if (parts.length >= 5) {
                            const filename = parts[5];
                            const agent = parts[2].slice(-4);

                            if (agent == {{ $agent->endpoint }}) {
                                console.log("agent:", agent);
                                console.log("filename:", filename);
                                Livewire.emit('filename', filename);

                                const modal = new bootstrap.Modal(document.getElementById(
                                    'updateTransactionCodeModal'));
                                modal.show();
                            }
                        } else {
                            console.error("Error: app_data does not contain enough parts.");
                        }


                    }
                });
                socket.addEventListener("error", (event) => {
                    console.error("WebSocket error:", event);
                    ws_socket.classList.remove("badge-success");
                    ws_socket.classList.add("badge-danger");
                    ws_socket.textContent = "Web socket error";

                    setTimeout(() => {
                        reConnect();
                    }, 5000); // Reconnect after 5 seconds
                });
                socket.addEventListener("close", (event) => {
                    ws_socket.classList.remove("badge-success");
                    ws_socket.classList.add("badge-danger");
                    ws_socket.textContent = "Web socket error";
                    console.log("WebSocket connection closed:", event);

                    setTimeout(() => {
                        reConnect();
                    }, 5000); // Reconnect after 5 seconds
                });

            }

            reConnect()
        })
    </script>
@endpush

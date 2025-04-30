<div class="container mt-4">
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
                    <h5 class="mb-0"><i class="fas fa-user-tie me-2"></i>Agent Dashboard</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Agent Information -->
                        <div class="col-md-4 border-end">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-green-light text-orange me-3">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Agent Information</h5>
                                </div>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-user me-2 text-secondary"></i>
                                    <strong>Name:</strong> {{ $agent->name }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-id-card me-2 text-secondary"></i>
                                    <strong>ID:</strong> {{ $agent->endpoint }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-phone me-2 text-secondary"></i>
                                    <strong>Number:</strong> {{ $agent->endpoint }}
                                </li>
                                <li>
                                    <i class="fas fa-power-off me-2 text-secondary"></i>
                                    <strong>Status:</strong>
                                    @switch($agent->status)
                                        @case('LOGGED_IN' || 'AgentState.LOGGEDIN')
                                            <span class="badge bg-success"><i class="fas fa-circle me-1"></i>LOGGED IN</span>
                                        @break

                                        @case('LOGGED_OUT' || 'AgentState.LOGGEDOUT')
                                            <span class="badge bg-secondary"><i class="fas fa-circle me-1"></i>LOGGED OUT</span>
                                        @break

                                        @case('IDLE' || 'AgentState.IDLE')
                                            <span class="badge bg-warning text-dark"><i
                                                    class="fas fa-circle me-1"></i>IDLE</span>
                                        @break

                                        @case('WITHDRAWN' || 'AgentState.WITHDRAWN')
                                            <span class="badge bg-danger"><i class="fas fa-circle me-1"></i>WITHDRAWN</span>
                                        @break

                                        @case('WRAPPING_UP' || 'AgentState.WRAPPINGUP')
                                            <span class="badge bg-info"><i class="fas fa-circle me-1"></i>WRAPPING UP</span>
                                        @break

                                        @case('ON_BREAK')
                                            <span class="badge bg-info"><i class="fas fa-circle me-1"></i>WRAPPING UP</span>
                                        @break

                                        @case('IN_CONVERSATION' || 'AgentState.ONCONVERSATION')
                                            <span class="badge bg-primary"><i class="fas fa-circle me-1"></i>IN
                                                CONVERSATION</span>
                                        @break

                                        @default
                                            <span class="badge bg-light text-dark"><i
                                                    class="fas fa-circle me-1"></i>{{ $agent->status }}</span>
                                    @endswitch
                                </li>
                            </ul>
                        </div>

                        <!-- Session Information -->
                        <div class="col-md-4 border-end">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary-light text-orange me-3">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Session Info</h5>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-info small d-flex align-items-center">
                                    <i class="fas fa-plug me-2"></i>Recorder Websocket:
                                    <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                                    <span id="ws-info" class="badge bg-info ms-2">Connecting...</span>
                                </label>
                            </div>

                            <div>
                                <strong class="d-flex align-items-center">
                                    <i class="fas fa-clock me-2"></i>Current Session:
                                </strong>
                                @if ($currentSession)
                                    <div class="d-flex align-items-center mt-1 mb-2">
                                        <span class="badge bg-primary me-2">{{ $currentSession->name }}</span>
                                        {{-- <button class="btn btn-sm btn-outline-primary" wire:click="showModal">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button> --}}

                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#sessionModal">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                    </div>
                                    <div class="small">
                                        <div><i class="far fa-clock me-2"></i>From: {{ $currentSession->time_from }}
                                        </div>
                                        <div><i class="far fa-clock me-2"></i>To: {{ $currentSession->time_to }}</div>
                                    </div>
                                @else
                                    <div class="alert alert-warning py-1 px-2 mt-2 small">
                                        <i class="fas fa-exclamation-triangle me-2"></i>No session selected
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {

                                            var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                                            sessionModal.show();
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>

                        <!-- Current Call -->
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary-light text-orange me-3">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0">Current Call</h5>
                                </div>
                            </div>
                            <div class="call-info">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-user-circle me-2 text-secondary"></i>
                                    <strong>Caller ID:</strong>
                                    <span class="ms-2">+1234567890</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-stopwatch me-2 text-secondary"></i>
                                    <strong>Duration:</strong>
                                    <span class="ms-2">00:03:15</span>
                                </div>

                                @if ($agent && $agent->status === config('constants.agent_status.ON_BREAK'))
                                    <div wire:poll.1s="updateBreakTimer">
                                        <div class="d-flex align-items-center mt-3">
                                            <i class="fas fa-stopwatch me-2 text-danger fw-bold fs-4"></i>
                                            <strong class="text-danger fs-5">Break Time Logger:</strong>
                                            <span class="ms-2 fw-bold text-danger fs-5">
                                                {{ $breakDuration }}
                                            </span>
                                        </div>
                                    </div>
                                @elseif ($breakLimitReached)
                                    <div class="text-danger fw-bold text-center mt-2">
                                        Break limit for this shift has been reached
                                    </div>
                                @endif





                                <div class="mt-3">
                                    @if (in_array($agent->status, ['LOGGED_OUT', 'WITHDRAWN']))
                                        {{-- LOGIN BUTTON --}}
                                        <form wire:submit.prevent="login">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="fas fa-sign-in-alt me-1"></i> Login
                                            </button>
                                        </form>
                                    @else
                                        {{-- LOGOUT AND BREAK/RESUME BUTTONS --}}
                                        <div class="d-flex gap-2">
                                            {{-- Break / Resume --}}
                                            <form wire:submit.prevent="toggleBreak" class="flex-fill">
                                                <button type="submit"
                                                    class="btn {{ $agent->status == 'ON_BREAK' ? 'btn-info' : 'btn-secondary' }} w-100">
                                                    <i class="fas fa-coffee me-1"></i>
                                                    {{ $agent->status == 'ON_BREAK' ? 'Resume' : 'Break' }}
                                                </button>
                                            </form>

                                            {{-- Logout --}}
                                            <form wire:submit.prevent="logout" class="flex-fill">
                                                <button type="submit" class="btn btn-warning w-100">
                                                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                                                </button>
                                            </form>
                                        </div>

                                        {{-- Break Timer --}}
                                        @if ($onBreak && $breakStartTime)
                                            <div class="mt-2 text-center text-info fw-bold">
                                                <small>On break for {{ $breakMinutes }} minute(s)</small>
                                            </div>
                                        @endif


                                    @endif
                                </div>

                                {{-- Auto-refresh every minute for timer --}}
                                <div x-data x-init="setInterval(() => Livewire.emit('refreshComponent'), 60000)"></div>

                            </div>
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


                <!-- Total Calls Card -->
                <div class="col-md-3 mb-4">
                    <div class="stats-card bg-primary-light">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="stats-content">
                            <h6>Calls in queue</h6>
                            <h3 id="queue-calls" wire:ignore>0</h3>
                            <div class="trend up">
                                <i class="fas fa-arrow-up"></i> 12% <span class="trend-text">vs yesterday</span>
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

            <!-- Combined Call Control and Incoming Call Information Card -->
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
                                            wire:click="selectTopic({{ $result['id'] }})" data-bs-toggle="modal"
                                            data-bs-target="#knowledgeModal">
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
                    <div class="quick-categories mt-4">
                        <h6 class="text-muted mb-3">Popular Categories:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-file-invoice-dollar me-1"></i> Billing
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-bolt me-1"></i> Outages
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-money-bill-wave me-1"></i> Payments
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-tools me-1"></i> Technical
                            </button>
                            <button class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="fas fa-id-card me-1"></i> Accounts
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Knowledge Modal -->
            <div class="modal fade" id="knowledgeModal" tabindex="-1" aria-labelledby="knowledgeModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow">
                        @if ($selectedTopic)
                            <div class="modal-header bg-primary text-white">
                                <div>
                                    <h5 class="modal-title" id="knowledgeModalLabel">
                                        <i class="fas fa-file-alt me-2"></i>{{ $selectedTopic->topic }}
                                    </h5>
                                    <small class="text-white-50">Last updated:
                                        {{ $selectedTopic->updated_at->format('M d, Y') }}</small>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close" wire:click="$set('selectedTopic', null)"></button>
                            </div>
                            <div class="modal-body p-4">
                                <div class="knowledge-content formatted-content">
                                    {!! $selectedTopic->description !!}
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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
            <!-- Combined Call Control and Incoming Call Information Card -->



            <!-- Combined Call Control and Incoming Call Information Card -->
            <!-- Customer Details Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-orange text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Customer Details</h5>
                    <div class="search-box" style="width: 300px;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" class="form-control border-start-0"
                                placeholder="Search by meter number or name..."
                                wire:model.debounce.200ms="meter_number" wire:keydown.enter="searchCustomer">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if ($customer_details && $customer_details->isNotEmpty())
                        @foreach ($customer_details as $customer)
                            <div class="customer-profile">
                                <div class="d-flex align-items-center mb-4">
                                    <div class="avatar bg-primary text-white me-3">
                                        {{ substr($customer->customer_name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="mb-0">{{ $customer->customer_name ?? '--' }}</h4>
                                        <p class="text-muted mb-0">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $customer->address ?? '--' }}
                                        </p>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary ms-auto"
                                        wire:click="showCustomerModal('{{ $customer->meter_serial_no }}')">
                                        <i class="fas fa-expand me-1"></i> Full View
                                    </button>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-section mb-4">
                                            <h6 class="section-title"><i class="fas fa-home me-2"></i>Address
                                                Information</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Division:</strong></p>
                                                    <p class="mb-3">{{ $customer->division ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Service Point:</strong></p>
                                                    <p class="mb-3">{{ $customer->service_point ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Meter #:</strong></p>
                                                    <p class="mb-3">{{ $customer->meter_serial_no ?? '--' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Town:</strong></p>
                                                    <p class="mb-3">{{ $customer->town ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Street:</strong></p>
                                                    <p class="mb-3">{{ $customer->street ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Service #:</strong></p>
                                                    <p class="mb-3">{{ $customer->service_no ?? '--' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info-section">
                                            <h6 class="section-title"><i class="fas fa-phone me-2"></i>Contact
                                                Information</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Home Phone:</strong></p>
                                                    <p class="mb-3">{{ $customer->home_phone ?? '--' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Business Phone:</strong></p>
                                                    <p class="mb-3">{{ $customer->buss_phone ?? '--' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="info-section mb-4">
                                            <h6 class="section-title"><i class="fas fa-bolt me-2"></i>Meter
                                                Information</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Meter Make:</strong></p>
                                                    <p class="mb-3">{{ $customer->meter_make ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Phase Type:</strong></p>
                                                    <p class="mb-3">{{ $customer->phase_type ?? '--' }}</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Tariff:</strong></p>
                                                    <p class="mb-3">{{ $customer->tariff ?? '--' }}</p>

                                                    <p class="mb-1"><strong>Landmark:</strong></p>
                                                    <p class="mb-3">{{ $customer->landmark ?? '--' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="info-section">
                                            <h6 class="section-title"><i
                                                    class="fas fa-info-circle me-2"></i>Additional Information</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="mb-1"><strong>Other Phone:</strong></p>
                                                    <p class="mb-3">{{ $customer->other_phone ?? '--' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5>No customer information</h5>
                            <p class="text-muted">Search for a customer by meter number or name</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Customer Modal -->
            <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel"
                aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="customerModalLabel">
                                <i class="fas fa-user-circle me-2"></i>
                                Customer Details: {{ $selectedCustomer->meter_serial_no ?? '' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if ($selectedCustomer)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="20%">Customer Name</th>
                                                <td width="30%">{{ $selectedCustomer->customer_name ?? '--' }}</td>
                                                <th width="20%">Home Phone</th>
                                                <td width="30%">{{ $selectedCustomer->home_phone ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Division</th>
                                                <td>{{ $selectedCustomer->division ?? '--' }}</td>
                                                <th>Town</th>
                                                <td>{{ $selectedCustomer->town ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Service Point</th>
                                                <td>{{ $selectedCustomer->service_point ?? '--' }}</td>
                                                <th>Street</th>
                                                <td>{{ $selectedCustomer->street ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td>{{ $selectedCustomer->address ?? '--' }}</td>
                                                <th>Landmark</th>
                                                <td>{{ $selectedCustomer->landmark ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meter Number</th>
                                                <td>{{ $selectedCustomer->meter_serial_no ?? '--' }}</td>
                                                <th>Meter Make</th>
                                                <td>{{ $selectedCustomer->meter_make ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tariff</th>
                                                <td>{{ $selectedCustomer->tariff ?? '--' }}</td>
                                                <th>Phase Type</th>
                                                <td>{{ $selectedCustomer->phase_type ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Service Number</th>
                                                <td>{{ $selectedCustomer->service_no ?? '--' }}</td>
                                                <th>Phone Number</th>
                                                <td>{{ $selectedCustomer->home_phone ?? '--' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Other Number</th>
                                                <td>{{ $selectedCustomer->buss_phone ?? '--' }}</td>
                                                <th>Other Number</th>
                                                <td>{{ $selectedCustomer->other_phone ?? '--' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Other info boxes here -->
                <div class="col-md-12">
                    <div class="info-box bg-info">
                        <span class="info-box-icon"><i class="fas fa-list"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Last Five Calls</span>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Agent number</th>
                                        <th>Caller phone</th>
                                        <th>Call date</th>
                                        <th>Duration</th>
                                        <th>Transaction code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lastFiveCalls as $call)
                                        <tr>
                                            <td>{{ $call->dst }}</td>
                                            <td>{{ $call->phone_number }}</td>
                                            <td>{{ $call->created_at ?? '--' }}</td>
                                            <td>{{ $call->call_duration }}</td>
                                            <td>{{ $call->disposition }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- WebSocket Data -->
            {{--            <div class="card mb-4"> --}}
            {{--                <div class="card-body"> --}}
            {{--                    <h5 class="card-title">WebSocket Data</h5> --}}
            {{--                    <pre id="json-data">[WebSocket Data Placeholder]</pre> --}}
            {{--                </div> --}}
            {{--            </div> --}}





            <!-- Session Selection Modal -->
            <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog"
                aria-labelledby="sessionModalLabel" aria-hidden="true" data-bs-backdrop="static"
                data-bs-keyboard="false" wire:ignore.self>
                selected {{ $selectedSession }}
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sessionModalLabel">Select Session</h5>
                        </div>
                        <div class="modal-body">
                            <select class="form-control" wire:model="selectedSession" wire:change="changeSession">
                                <option value="">Select Session</option>
                                @foreach ($sessions as $session)
                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            @if ($selectedSession == null)
                                <button type="button" class="btn btn-primary disabled" wire:click="saveSession">Save
                                    changes ...</button>
                            @else
                                <button type="button" class="btn btn-primary" wire:click="saveSession"
                                    data-bs-dismiss="modal">
                                    Save changes
                                </button>
                            @endif
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

    <script>
        const iframe = document.getElementById('myIframe');
        iframe.onload = function() {
            iframe.contentWindow.postMessage({
                man_no: {{ $agent->endpoint }}
            }, 'http://localhost:8000');
        };
    </script>


</div>

@push('custom-scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



    <script>
        document.addEventListener('livewire:load', function() {
            @this.on('openSessionModal', () => {
                var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                sessionModal.show();
            });

            @this.on('closeSessionModal', () => {
                var sessionModal = bootstrap.Modal.getInstance(document.getElementById('sessionModal'));

                console.log("Closing modal")
                if (sessionModal) {
                    sessionModal.hide();
                }
            });

            // Automatically trigger open if selectedSession is null at page load
            @if ($selectedSession == null)
                var sessionModal = new bootstrap.Modal(document.getElementById('sessionModal'));
                sessionModal.show();
            @endif
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
                            var queueCalls=0;

                            for(let i = 0; i < holdingBridges.length; i++) {
                                queueCalls += holdingBridges[i].channels.length;
                            }

                        // Update DOM with the count (you can change this element ID)
                        document.getElementById("queue-calls").innerHTML = `${queueCalls}`;

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
                    Livewire.emit('refreshComponent');
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
@endpush

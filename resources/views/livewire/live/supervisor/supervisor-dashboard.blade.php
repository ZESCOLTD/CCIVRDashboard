<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0" style="color: #0f974b; font-weight: 600;">
                    <i class="fas fa-tachometer-alt mr-2" style="color: #f49e38;"></i>
                    ZESCO Call Centre Dashboard
                </h1>
                <div class="text-right">
                    <span class="badge px-3 py-2" style="background-color: #0f974b; color: white; font-size: 0.9rem;">
                        <i class="fas fa-circle mr-1"></i> Real-time Monitoring
                    </span>
                </div>
            </div>
            <hr style="border-top: 3px solid #f49e38; opacity: 0.7;">
        </div>
    </div>

    <!-- Main Dashboard Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-lg" style="border-radius: 10px; overflow: hidden;">
                <div class="card-header py-3" style="background-color: #0f974b; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user-shield mr-2"></i>
                            Supervisor Control Panel
                        </h5>
                        <div>
                            <span class="badge badge-light mr-2">
                                <i class="fas fa-clock mr-1"></i> <span id="currentTime">Loading...</span>
                            </span>
                            <span class="badge badge-light">
                                <i class="fas fa-calendar-alt mr-1"></i> <span id="currentDate">Loading...</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);">
                    <div class="row">
                        <!-- Supervisor Info (Left Column) -->
                        <div class="col-md-4 border-right pr-4"
                            style="border-color: rgba(244, 158, 56, 0.3) !important;">
                            <h6 class="card-subtitle mb-3"
                                style="color: #0f974b; font-weight: 600; border-bottom: 2px solid #f49e38; padding-bottom: 6px;">
                                <i class="fas fa-user-tie mr-2"></i>Supervisor Information
                            </h6>
                            <div class="pl-3">
                                <p class="mb-2">
                                    <strong
                                        style="color: #0f974b; min-width: 120px; display: inline-block;">Name:</strong>
                                    <span style="color: #333;">{{ $user->name }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong style="color: #0f974b; min-width: 120px; display: inline-block;">Employee
                                        No:</strong>
                                    <span style="color: #333;">{{ $user->man_no }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong
                                        style="color: #0f974b; min-width: 120px; display: inline-block;">Department:</strong>
                                    <span style="color: #333;">Customer Support</span>
                                </p>
                                <p class="mb-0">
                                    <strong
                                        style="color: #0f974b; min-width: 120px; display: inline-block;">Status:</strong>
                                    <span class="badge px-2 py-1"
                                        style="background-color: {{ $user->isOnline() ? '#0f974b' : '#6c757d' }}; color: white; font-size: 0.8rem;">
                                        <i class="fas {{ $user->isOnline() ? 'fa-wifi' : 'fa-clock' }} mr-1"></i>
                                        {{ $user->isOnline() ? 'Online' : 'Offline' }}
                                        @if ($user->is_banned)
                                            <i class="fas fa-ban ml-1"></i>
                                        @endif
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- System Status (Middle Column) -->
                        <div class="col-md-4 border-right px-4"
                            style="border-color: rgba(244, 158, 56, 0.3) !important;">
                            <h6 class="card-subtitle mb-3"
                                style="color: #0f974b; font-weight: 600; border-bottom: 2px solid #f49e38; padding-bottom: 6px;">
                                <i class="fas fa-server mr-2"></i>System Status
                            </h6>
                            <div class="pl-3">
                                <div class="mb-3">
                                    <label style="color: #0f974b; display: block; margin-bottom: 2px;">
                                        <i class="fas fa-plug mr-1"></i>Recorder Websocket:
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                                        <span id="ws-info" class="badge px-2 py-1"
                                            style="background-color: #0f974b; color: white; font-size: 0.8rem;">
                                            <i class="fas fa-check-circle mr-1"></i>Connected
                                        </span>
                                        <i class="fas fa-info-circle ml-2" style="color: #f49e38; cursor: pointer;"
                                            data-toggle="tooltip" title="WebSocket connection status"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label style="color: #0f974b; display: block; margin-bottom: 2px;">
                                        <i class="fas fa-exchange-alt mr-1"></i>Recorder Rest Interface:
                                    </label>
                                    <input class="form-control form-control-sm" type="text" id="api_endpoint"
                                        value='{{ $api_server }}'
                                        style="border-color: #f49e38; color: #0f974b; background-color: rgba(244, 158, 56, 0.05);">
                                </div>
                                <div>
                                    <label style="color: #0f974b; display: block; margin-bottom: 2px;">
                                        <i class="fas fa-database mr-1"></i>Database Status:
                                    </label>
                                    <span class="badge px-2 py-1"
                                        style="background-color: #0f974b; color: white; font-size: 0.8rem;">
                                        <i class="fas fa-check-circle mr-1"></i>Connected
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Team Overview (Right Column) -->
                        <div class="col-md-4 pl-4">
                            <h6 class="card-subtitle mb-3"
                                style="color: #0f974b; font-weight: 600; border-bottom: 2px solid #f49e38; padding-bottom: 6px;">
                                <i class="fas fa-users mr-2"></i>Team Overview
                            </h6>
                            <div class="pl-3">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="color: #0f974b;">
                                            <i class="fas fa-user-check mr-1"></i>Active Agents:
                                        </span>
                                        <span style="color: #333;"
                                            id="active-agents">{{ $availableAgentsCount }}/{{ $totalAgentCount }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar"
                                            style="background-color: #0f974b; width: {{ ($availableAgentsCount / $totalAgentCount) * 100 }}%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="color: #0f974b;">
                                            <i class="fas fa-phone-alt mr-1"></i>Calls in Progress:
                                        </span>
                                        <span
                                            style="color: #333;">{{ $activeCalls }}/{{ $availableAgentsCount }}</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar"
                                            style="background-color: #28a745; width: {{ ($activeCalls / $availableAgentsCount) * 100 }}%;">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span style="color: #0f974b;">
                                            <i class="fas fa-hourglass-half mr-1"></i>Queue Wait Time:
                                        </span>
                                        <span style="color: #333;">4:32</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar" style="background-color: #fd7e14; width: 65%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="card-subtitle mb-3"
                                style="color: #0f974b; font-weight: 600; border-bottom: 2px solid #f49e38; padding-bottom: 6px;">
                                <i class="fas fa-bolt mr-2"></i>Quick Actions
                            </h6>
                            <div class="d-flex flex-wrap">
                                <button class="btn btn-sm mr-2 mb-2" style="background-color: #0f974b; color: white;"
                                    data-toggle="modal" data-target="#broadcastModal">
                                    <i class="fas fa-broadcast-tower mr-1"></i> Broadcast Message
                                </button>
                                <button class="btn btn-sm mr-2 mb-2" style="background-color: #28a745; color: white;"
                                    data-toggle="modal" data-target="#agentManagementModal">
                                    <i class="fas fa-user-plus mr-1"></i> Add Agent
                                </button>
                                <button class="btn btn-sm mr-2 mb-2" style="background-color: #fd7e14; color: white;">
                                    <i class="fas fa-phone-volume mr-1"></i> Listen to Call
                                </button>
                                <button class="btn btn-sm mr-2 mb-2" style="background-color: #6f42c1; color: white;">
                                    <i class="fas fa-chart-pie mr-1"></i> Generate Report
                                </button>
                                <button class="btn btn-sm mr-2 mb-2" style="background-color: #dc3545; color: white;">
                                    <i class="fas fa-phone-slash mr-1"></i> End All Calls
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <style>
                    /* Smooth transitions and animations */
                    #broadcastModal {
                        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
                    }

                    #broadcastModal .modal-content {
                        transform: translateY(-20px);
                        opacity: 0;
                        transition: all 0.3s ease-out;
                    }

                    #broadcastModal.show .modal-content {
                        transform: translateY(0);
                        opacity: 1;
                    }

                    #broadcastIframe {
                        opacity: 0;
                    }

                    /* Hover effects for buttons */
                    .modal-footer button:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                        transition: all 0.2s ease;
                    }

                    .modal-header .close:hover {
                        opacity: 1 !important;
                        transform: rotate(90deg);
                    }
                </style>

                <!-- Modal Structure -->
                <div class="modal fade" id="broadcastModal" tabindex="-1" role="dialog"
                    aria-labelledby="broadcastModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document" style="max-width: 1080px; height: 900px;">
                        <div class="modal-content"
                            style="height: 100%; border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(15, 151, 75, 0.3);">
                            <!-- Modal Header with gradient -->
                            <div class="modal-header"
                                style="background: linear-gradient(135deg, #0f974b 0%, #0a7a3b 100%); color: white; border-bottom: 2px solid #f49e38; padding: 15px 20px;">
                                <h5 class="modal-title" id="broadcastModalLabel"
                                    style="font-weight: 600; letter-spacing: 0.5px;">
                                    <i class="fas fa-broadcast-tower mr-2"></i>Broadcast Message Center
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    style="color: white; text-shadow: none; opacity: 0.8; transition: all 0.3s;">
                                    <span aria-hidden="true" style="font-size: 1.75rem;">&times;</span>
                                </button>
                            </div>

                            <!-- Modal Body with perfect iframe dimensions -->
                            <div class="modal-body" style="padding: 0; height: calc(100% - 110px);">
                                <iframe src="http://sms.zesco.co.zm/zesco/push/rcc_broadcast_new.html" frameborder="0"
                                    style="width: 100%; height: 100%; transition: opacity 0.5s ease;"
                                    id="broadcastIframe" onload="this.style.opacity='1'"></iframe>
                            </div>

                            <!-- Enhanced Modal Footer -->
                            <div class="modal-footer"
                                style="background: linear-gradient(to right, #f8f9fa 0%, #e9ecef 100%); border-top: 1px solid rgba(244, 158, 56, 0.3); padding: 12px 20px;">
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <small class="text-muted" style="color: #0f974b !important;">
                                        <i class="fas fa-info-circle mr-1"></i> All messages are logged for security
                                        purposes
                                    </small>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-secondary mr-2"
                                            data-dismiss="modal" style="border-color: #6c757d; min-width: 90px;">
                                            <i class="fas fa-times mr-1"></i> Close
                                        </button>
                                        <button type="button" class="btn btn-sm shadow-sm"
                                            style="background: linear-gradient(to right, #0f974b 0%, #0a7a3b 100%); color: white; border: none; min-width: 150px;"
                                            onclick="submitBroadcast()">
                                            <i class="fas fa-paper-plane mr-1"></i> Send Broadcast
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Card Footer -->
                <div class="card-footer py-2"
                    style="background-color: rgba(15, 151, 75, 0.1); border-top: 1px solid rgba(244, 158, 56, 0.3);">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-sync-alt mr-1" style="color: #f49e38;"></i>
                            Last updated: <span id="lastUpdated">Just now</span>
                            <span id="syncStatus" class="ml-2"></span>
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-shield-alt mr-1" style="color: #f49e38;"></i>
                            System Version: 2.4.1 | Last Login: Today, 08:45 AM
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- First Card Handling Code DO NOT DELETE --}}


    <!-- Key Metrics Overview -->
    <div class="container-fluid">
        <!-- Supervisor Header Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h4><i class="fas fa-user-shield mr-2"></i>Supervisor Dashboard</h4>
                                <p class="mb-0"><strong>Supervisor:</strong> John Doe (ID: 12345)</p>
                                <p class="mb-0"><strong>Status:</strong> <span
                                        class="badge badge-success">Online</span>
                                </p>
                            </div>
                            <div class="col-md-4 text-center">
                                <h5>System Status</h5>
                                <span class="badge badge-success mr-2"><i class="fas fa-plug"></i> WebSocket
                                    Connected</span>
                                <span class="badge badge-success"><i class="fas fa-server"></i> API Connected</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <button class="btn btn-sm btn-outline-primary mr-2"><i class="fas fa-sync-alt"></i>
                                    Refresh</button>
                                <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-cog"></i>
                                    Settings</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Live Call Metrics -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-orange text-white">
                        <h5><i class="fas fa-phone-volume mr-2"></i>Live Call Metrics</h5>
                    </div>
                    <div class="card-body">
                        <!-- Row 1 -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-phone-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Active Calls</span>
                                        <span class="info-box-number" id="activeCalls">{{ $activeCalls }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 70%"></div>
                                        </div>
                                        <span class="progress-description">70% of capacity</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-hourglass-half"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Queue Calls</span>
                                        <span class="info-box-number" id="queue-calls">0</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 40%"></div>
                                        </div>
                                        <span class="progress-description">4 waiting > 1 min</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Longest Wait</span>
                                        <span class="info-box-number">04:32</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 85%"></div>
                                        </div>
                                        <span class="progress-description">Above SLA</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Answered</span>
                                        <span class="info-box-number">{{ $answeredCalls }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 90%"></div>
                                        </div>
                                        <span class="progress-description">Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Row 2 -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-box bg-secondary">
                                    <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Abandoned</span>
                                        <span class="info-box-number">{{ $abandoned }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 15%"></div>
                                        </div>
                                        <span class="progress-description">Today</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="info-box bg-dark">
                                    <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Failed Calls</span>
                                        <span class="info-box-number">5</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 25%"></div>
                                        </div>
                                        <span class="progress-description">Today</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-box bg-purple">
                                    <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">SLA Compliance</span>
                                        <span class="info-box-number">78%</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 78%"></div>
                                        </div>
                                        <span class="progress-description">Target: 80%</span>
                                    </div>
                                </div>
                            </div>







                            <div class="col-md-3">
                                <div class="info-box bg-teal">
                                    <span class="info-box-icon"><i class="fas fa-tachometer-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Efficiency Level</span>
                                        <span class="info-box-number">{{ $efficiencyLast30 }}%</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: 88%"></div>
                                        </div>
                                        <span class="progress-description">Target: 90%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- 2. Agent Statistics -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="fas fa-users mr-2"></i>Agent Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>{{ $loggedInAgentsCount }}</h3>
                                        <p>Agents Logged In</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">View All <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $availableAgentsCount }}</h3>

                                        <p>Available</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-headset"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Details <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $onBreak }}</h3>
                                        <p>On Break</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-coffee"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Break Log <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="small-box bg-secondary">
                                    <div class="inner">
                                        <h3>{{ $loggedOut }}</h3>
                                        <p>Offline</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-power-off"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">Manage <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title"><i class="fas fa-stopwatch mr-2"></i>Average Talk Time
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <h3>{{ floor($averageDuration / 60) }}min: {{ $averageDuration % 60 }}sec</h3>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 65%"></div>
                                        </div>
                                        <small>Target: < 4 minutes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title"><i class="fas fa-pause-circle mr-2"></i>Average Hold
                                            Time
                                        </h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <h3>00:32</h3>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 45%"></div>
                                        </div>
                                        <small>Target: < 30 seconds</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5><i class="fas fa-chart-pie mr-2"></i>Agent Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px;">
                            <canvas id="agentStatusChart"></canvas>
                        </div>
                        <div class="mt-3 text-center">
                            <span class="mr-3"><i class="fas fa-circle text-success"></i> Available
                                ({{ $availableAgentsCount }})</span>
                            <span class="mr-3"><i class="fas fa-circle text-primary"></i> On Call
                                ({{ $activeCalls }})</span>
                            <span class="mr-3"><i class="fas fa-circle text-warning"></i> On Break
                                ({{ $onBreak }})</span>
                            <span><i class="fas fa-circle text-secondary"></i> Offline ({{ $loggedOut }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Call History & Trends -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-chart-line mr-2"></i>Call History & Trends</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Total Calls</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <h5>{{ $answeredCalls }}</h5>
                                                <small>Today</small>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h5>210</h5>
                                                <small>This Week</small>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <h5>850</h5>
                                                <small>This Month</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Call Volume by Hour</h6>
                                    </div>
                                    <div class="card-body">
                                        <div style="height: 200px;">
                                            <canvas id="callVolumeChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Call Distribution by Department</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 text-center">
                                                <h5>Sales</h5>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" style="width: 45%">45%</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <h5>Support</h5>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" style="width: 30%">30%</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <h5>Billing</h5>
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" style="width: 15%">15%</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 text-center">
                                                <h5>Other</h5>
                                                <div class="progress">
                                                    <div class="progress-bar bg-secondary" style="width: 10%">10%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Queue Statistics -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5><i class="fas fa-list-ol mr-2"></i>Queue Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h6>Sales Queue</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><i class="fas fa-phone mr-2"></i> Answered: 32</p>
                                        <p><i class="fas fa-times mr-2"></i> Missed: 5</p>
                                        <p><i class="fas fa-stopwatch mr-2"></i> Avg Answer: 00:28</p>
                                        <p><i class="fas fa-check-circle mr-2"></i> SLA: 82%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6>Support Queue</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><i class="fas fa-phone mr-2"></i> Answered: 45</p>
                                        <p><i class="fas fa-times mr-2"></i> Missed: 3</p>
                                        <p><i class="fas fa-stopwatch mr-2"></i> Avg Answer: 00:35</p>
                                        <p><i class="fas fa-check-circle mr-2"></i> SLA: 88%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h6>Billing Queue</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><i class="fas fa-phone mr-2"></i> Answered: 18</p>
                                        <p><i class="fas fa-times mr-2"></i> Missed: 2</p>
                                        <p><i class="fas fa-stopwatch mr-2"></i> Avg Answer: 00:42</p>
                                        <p><i class="fas fa-check-circle mr-2"></i> SLA: 75%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-secondary text-white">
                                        <h6>General Queue</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><i class="fas fa-phone mr-2"></i> Answered: 12</p>
                                        <p><i class="fas fa-times mr-2"></i> Missed: 1</p>
                                        <p><i class="fas fa-stopwatch mr-2"></i> Avg Answer: 00:38</p>
                                        <p><i class="fas fa-check-circle mr-2"></i> SLA: 85%</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Wallboard Dashboard -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5><i class="fas fa-tv mr-2"></i>Wallboard Dashboard</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card bg-dark text-white">
                                    <div class="card-body text-center">
                                        <h3><i class="fas fa-phone-alt"></i> Live Calls</h3>
                                        <h1 class="display-4" id="liveCalls">24</h1>
                                        <div class="mt-3">
                                            <span class="badge badge-success mr-2">{{ $activeCalls }} In
                                                Progress</span>
                                            <span class="badge badge-warning" id="inQueue">8 In Queue</span>
                                            <span class="badge badge-danger">4 Waiting</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4>Call Queue Heatmap</h4>
                                        <div style="height: 200px;">
                                            <canvas id="heatmapChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4>Agent Status Grid</h4>
                                        <div class="agent-grid">
                                            <span class="agent-status available">A</span>
                                            <span class="agent-status busy">B</span>
                                            <span class="agent-status available">C</span>
                                            <span class="agent-status break">D</span>
                                            <span class="agent-status available">E</span>
                                            <span class="agent-status busy">F</span>
                                            <span class="agent-status offline">G</span>
                                            <span class="agent-status available">H</span>
                                            <span class="agent-status busy">I</span>
                                            <span class="agent-status available">J</span>
                                            <span class="agent-status break">K</span>
                                            <span class="agent-status available">L</span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge badge-success mr-2">Available</span>
                                            <span class="badge badge-primary mr-2">Busy</span>
                                            <span class="badge badge-warning mr-2">Break</span>
                                            <span class="badge badge-secondary">Offline</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-center">Daily Call Stats</h5>
                                        <div style="height: 250px;">
                                            <canvas id="dailyStatsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-center">Weekly Call Distribution</h5>
                                        <div style="height: 250px;">
                                            <canvas id="weeklyStatsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Reporting & Export -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5><i class="fas fa-file-export mr-2"></i>Reporting & Export</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Generate Report</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Report Type</label>
                                            <select class="form-control">
                                                <option>Daily Summary</option>
                                                <option>Weekly Summary</option>
                                                <option>Agent Performance</option>
                                                <option>Queue Performance</option>
                                                <option>Call Volume Analysis</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Date Range</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">to</span>
                                                </div>
                                                <input type="date" class="form-control">
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-block">Generate Report</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Export Options</h6>
                                    </div>
                                    <div class="card-body text-center">
                                        <button class="btn btn-outline-success mb-2 btn-block"><i
                                                class="fas fa-file-excel mr-2"></i> Export to Excel</button>
                                        <button class="btn btn-outline-info mb-2 btn-block"><i
                                                class="fas fa-file-csv mr-2"></i> Export to CSV</button>
                                        <button class="btn btn-outline-danger mb-2 btn-block"><i
                                                class="fas fa-file-pdf mr-2"></i> Export to PDF</button>
                                        <button class="btn btn-outline-secondary btn-block"><i
                                                class="fas fa-envelope mr-2"></i> Email Report</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Automated Reports</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="dailyReportSwitch" checked>
                                                <label class="custom-control-label" for="dailyReportSwitch">Daily
                                                    Summary</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="weeklyReportSwitch">
                                                <label class="custom-control-label" for="weeklyReportSwitch">Weekly
                                                    Summary</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Recipients</label>
                                            <input type="text" class="form-control"
                                                value="managers@company.com, supervisors@company.com">
                                        </div>
                                        <button class="btn btn-info btn-block">Save Settings</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Agent Status Chart
        const agentStatusCtx = document.getElementById('agentStatusChart').getContext('2d');
        const agentStatusChart = new Chart(agentStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Available', 'On Call', 'On Break', 'Offline'],
                datasets: [{
                    data: [12, 5, 5, 1],
                    backgroundColor: [
                        '#28a745',
                        '#007bff',
                        '#ffc107',
                        '#6c757d'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                }
            }
        });

        // Call Volume Chart
        const callVolumeCtx = document.getElementById('callVolumeChart').getContext('2d');
        const callVolumeChart = new Chart(callVolumeCtx, {
            type: 'bar',
            data: {
                labels: ['8-9', '9-10', '10-11', '11-12', '12-1', '1-2', '2-3', '3-4', '4-5'],
                datasets: [{
                    label: 'Calls per Hour',
                    data: [5, 8, 12, 15, 10, 7, 9, 11, 6],
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: false
                }
            }
        });

        // Heatmap Chart
        const heatmapCtx = document.getElementById('heatmapChart').getContext('2d');
        const heatmapChart = new Chart(heatmapCtx, {
            type: 'bar',
            data: {
                labels: ['Sales', 'Support', 'Billing', 'General'],
                datasets: [{
                    label: 'Current Queue',
                    data: [8, 5, 3, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: false
                }
            }
        });

        // Daily Stats Chart
        const dailyStatsCtx = document.getElementById('dailyStatsChart').getContext('2d');
        const dailyStatsChart = new Chart(dailyStatsCtx, {
            type: 'pie',
            data: {
                labels: ['Answered', 'Missed', 'Abandoned'],
                datasets: [{
                    data: [42, 5, 3],
                    backgroundColor: [
                        '#28a745',
                        '#dc3545',
                        '#ffc107'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });

        // Weekly Stats Chart
        const weeklyStatsCtx = document.getElementById('weeklyStatsChart').getContext('2d');
        const weeklyStatsChart = new Chart(weeklyStatsCtx, {
            type: 'polarArea',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                datasets: [{
                    data: [35, 42, 38, 45, 50],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'right'
                }
            }
        });
    </script>

    <style>
        .info-box {
            border-radius: 5px;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            min-height: 90px;
        }

        .info-box-icon {
            float: left;
            font-size: 30px;
            padding: 15px;
        }

        .info-box-content {
            margin-left: 70px;
        }

        .info-box-text {
            display: block;
            font-size: 14px;
        }

        .info-box-number {
            display: block;
            font-size: 24px;
            font-weight: bold;
        }

        .small-box {
            border-radius: 5px;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            position: relative;
        }

        .small-box .icon {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 50px;
            opacity: 0.3;
        }

        .small-box .inner {
            padding: 10px;
        }

        .small-box h3 {
            font-size: 24px;
            margin: 0;
        }

        .small-box p {
            margin: 0;
        }

        .small-box-footer {
            display: block;
            padding: 5px 10px;
            color: white;
            background: rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .agent-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .agent-status {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }

        .agent-status.available {
            background-color: #28a745;
        }

        .agent-status.busy {
            background-color: #007bff;
        }

        .agent-status.break {
            background-color: #ffc107;
        }

        .agent-status.offline {
            background-color: #6c757d;
        }

        .bg-purple {
            background-color: #6f42c1 !important;
        }
    </style>
    @push('custom-scripts')
        <script>
            // Function to update the display of selected agents
            function updateSelectedAgents() {
                const agentSelect = document.getElementById("agentSelect");
                const selectedAgents = Array.from(agentSelect.selectedOptions).map(option => option.text);
                const selectedAgentsDiv = document.getElementById("selectedAgents");

                if (selectedAgents.length > 0) {
                    selectedAgentsDiv.innerHTML = `<ul>${selectedAgents.map(agent => `<li>${agent}</li>`).join('')}</ul>`;
                } else {
                    selectedAgentsDiv.innerHTML = '<p class="text-muted">No agents selected yet.</p>';
                }
            }

            // Function to log in multiple agents
            function logInMultipleAgents() {
                const agentSelect = document.getElementById("agentSelect");
                const selectedAgents = Array.from(agentSelect.selectedOptions).map(option => option.text);

                if (selectedAgents.length > 0) {
                    // Logic for logging in the selected agents (AJAX or WebSocket call)
                    alert(`The following agents have been logged in: \n${selectedAgents.join(", ")}`);
                    // Clear selection after login
                    agentSelect.selectedIndex = -1;
                    updateSelectedAgents(); // Update the displayed selected agents
                } else {
                    alert("Please select at least one agent to log in.");
                }
            }

            // Function to log out multiple agents
            function logOutMultipleAgents() {
                const agentSelect = document.getElementById("agentSelect");
                const selectedAgents = Array.from(agentSelect.selectedOptions).map(option => option.text);

                if (selectedAgents.length > 0) {
                    // Logic for logging out the selected agents (AJAX or WebSocket call)
                    alert(`The following agents have been logged out: \n${selectedAgents.join(", ")}`);
                    // Clear selection after logout
                    agentSelect.selectedIndex = -1;
                    updateSelectedAgents(); // Update the displayed selected agents
                } else {
                    alert("Please select at least one agent to log out.");
                }
            }
        </script>
    @endpush


    {{-- <!-- WebSocket Data (For System Monitoring) --> --}}
    {{-- <div class="card mb-4"> --}}
    {{--    <div class="card-body"> --}}
    {{--        <h5 class="card-title">WebSocket Data</h5> --}}
    {{--        <pre id="json-data">[WebSocket Data Placeholder]</pre> --}}
    {{--    </div> --}}
    {{-- </div> --}}
    {{-- </div> --}}

    @push('custom-scripts')
        <script>
            // Function to format the timestamp with ZESCO colors
            function updateLastUpdated() {
                const now = new Date();
                const options = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                };

                // Format with ZESCO color accents
                const timeString = now.toLocaleTimeString('en-US', options);
                const lastUpdated = document.getElementById('lastUpdated');

                // Display with colored seconds for better visibility
                const [time, period] = timeString.split(' ');
                const [hours, minutes, seconds] = time.split(':');

                lastUpdated.innerHTML =
                    `${hours}:<span style="color:#0f974b">${minutes}</span>:<span style="color:#f49e38">${seconds}</span> ${period}`;

                // Add rotating sync icon effect
                const syncIcon = document.querySelector('.fa-sync-alt');
                syncIcon.style.transition = 'transform 0.5s ease';
                syncIcon.style.transform = 'rotate(180deg)';
                setTimeout(() => {
                    syncIcon.style.transform = 'rotate(0deg)';
                }, 500);
            }

            // Initial update
            updateLastUpdated();

            // Update every second
            const syncInterval = setInterval(updateLastUpdated, 1000);

            // Optional: Add sync status indicator
            function updateSyncStatus() {
                const statusElement = document.getElementById('syncStatus');
                const statuses = [{
                        text: "Syncing data...",
                        class: "text-info"
                    },
                    {
                        text: "Connection stable",
                        class: "text-success"
                    },
                    {
                        text: "Real-time active",
                        class: "text-primary"
                    }
                ];

                let currentStatus = 0;

                setInterval(() => {
                    statusElement.textContent = statuses[currentStatus].text;
                    statusElement.className = `ml-2 ${statuses[currentStatus].class}`;
                    currentStatus = (currentStatus + 1) % statuses.length;
                }, 3000);
            }

            // Uncomment to enable status messages
            // updateSyncStatus();

            // For actual data sync integration:
            function syncDashboardData() {
                // Your data fetching logic here
                console.log("Syncing dashboard data...");

                // After successful sync:
                const now = new Date();
                document.getElementById('lastUpdated').dataset.lastSync = now.getTime();
            }

            // Uncomment to sync data every 30 seconds
            // setInterval(syncDashboardData, 30000);
        </script>

        <script>
            // Real-time status update (optional)
            document.addEventListener('DOMContentLoaded', function() {
                function updateStatus() {
                    fetch('{{ route('api.user.status') }}')
                        .then(response => response.json())
                        .then(data => {
                            const statusBadge = document.querySelector('#statusBadge');
                            if (statusBadge) {
                                statusBadge.innerHTML =
                                    `<i class="fas ${data.online ? 'fa-wifi' : 'fa-clock'} mr-1"></i>${data.online ? 'Online' : 'Offline'}`;
                                statusBadge.style.backgroundColor = data.online ? '#0f974b' : '#6c757d';
                            }
                        });
                }

                // Update every 30 seconds
                setInterval(updateStatus, 30000);

                // Update on user activity
                document.addEventListener('mousemove', updateStatus);
                document.addEventListener('keypress', updateStatus);
            });
        </script>


        <script>
            window.addEventListener('load', () => {
                const apiUrl = "http://10.44.0.70:8088/ari/bridges?api_key=asterisk:asterisk";

                const liveCallsElement = document.getElementById("liveCalls");
                let liveCalls = 0;

                function fetchBridgeData() {
                    fetch(apiUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("API Response:", data);

                            // Filter bridges of type 'mixing'
                            const mixingBridges = data.filter(bridge => bridge.bridge_type === 'mixing' && bridge
                                .channels.length > 0);

                            liveCalls = mixingBridges.length;
                            // Update DOM with the count (you can change this element ID)
                            document.getElementById("activeCalls").textContent = `${mixingBridges.length}`;
                        })
                        .catch(error => {
                            console.error("Fetch error:", error);
                        });
                }

                function fetchHoldingBridgeData() {
                    fetch(apiUrl)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log("API Response:", data);

                            // Filter bridges of type 'mixing'
                            const holdingBridges = data.filter(bridge => bridge.bridge_type === 'holding' && bridge
                                .channels.length > 0);
                            var queueCalls = 0;

                            for (let i = 0; i < holdingBridges.length; i++) {
                                queueCalls += holdingBridges[i].channels.length;
                            }

                            // Update DOM with the count (you can change this element ID)
                            document.getElementById("inQueue").textContent = `Queue Bridges: ${queueCalls}`;
                            document.getElementById("queue-calls").textContent = `${queueCalls}`;



                            liveCalls += queueCalls;
                            liveCallsElement.textContent = `${liveCalls}`;
                        })
                        .catch(error => {
                            console.error("Fetch error:", error);
                        });
                }


                // Initial fetch
                function prob() {
                    fetchBridgeData();
                    fetchHoldingBridgeData();
                }

                // Repeat every 5 seconds (5000 ms)
                setInterval(prob, 5000);



                // WebSocket connection and event listeners as in the original code
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

                    if (data.type == "StasisStart") {
                        // incomingCall.innerHTML = JSON.stringify(data.channel.caller, null, 4);
                        prob();
                    }
                    if (data.type == "StasisEnd") {
                        // incomingCall.innerHTML = "";
                        prob();
                    }
                    console.log("Message from server:", event.data);
                });

                socket.addEventListener("error", (event) => {
                    console.error("WebSocket error:", event);
                    ws_socket.classList.remove("badge-success");
                    ws_socket.classList.add("badge-danger");
                    ws_socket.textContent = "Web socket error";
                });

                socket.addEventListener("close", (event) => {
                    ws_socket.classList.remove("badge-success");
                    ws_socket.classList.add("badge-danger");
                    ws_socket.textContent = "Web socket error";
                    console.log("WebSocket connection closed:", event);
                });


            });
        </script>
        <script>
            // Enhance modal show/hide with animations
            $('#broadcastModal').on('show.bs.modal', function() {
                setTimeout(() => {
                    $(this).addClass('show');
                }, 10);
            });

            $('#broadcastModal').on('hidden.bs.modal', function() {
                $(this).removeClass('show');
            });

            function submitBroadcast() {
                try {
                    const iframe = document.getElementById('broadcastIframe');
                    iframe.contentWindow.postMessage('submitBroadcast', 'http://sms.zesco.co.zm');

                    // Visual feedback
                    const btn = event.target;
                    btn.innerHTML = '<i class="fas fa-check mr-1"></i> Sending...';
                    btn.style.background = 'linear-gradient(to right, #28a745 0%, #1e7e34 100%)';

                    setTimeout(() => {
                        $('#broadcastModal').modal('hide');
                        // Show success toast
                        showToast('Broadcast sent successfully!', 'success');
                    }, 1500);
                } catch (e) {
                    showToast('Error sending broadcast', 'error');
                    console.error("Broadcast error:", e);
                }
            }

            function showToast(message, type) {
                // Implement your toast notification here
                console.log(`${type}: ${message}`);
            }
        </script>
    @endpush

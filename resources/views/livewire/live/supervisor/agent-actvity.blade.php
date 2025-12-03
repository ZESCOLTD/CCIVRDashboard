<div class="container mt-4">
    <div class="card-body" style="background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);">

        <div class="row">

            <div class="col-md-4 border-right pr-4" style="border-color: rgba(244, 158, 56, 0.3) !important;">

                <h6 class="card-subtitle mb-3"
                    style="color: #0f974b; font-weight: 600; border-bottom: 2px solid #f49e38; padding-bottom: 6px;">

                    <i class="fas fa-user-tie mr-2"></i>Supervisor Information

                </h6>

                <div class="pl-3">

                    <p class="mb-2">

                        <strong style="color: #0f974b; min-width: 120px; display: inline-block;">Name:</strong>

                        <span style="color: #333;">{{ $user->name }}</span>

                    </p>

                    <p class="mb-2">

                        <strong style="color: #0f974b; min-width: 120px; display: inline-block;">Employee

                            No:</strong>

                        <span style="color: #333;">{{ $user->man_no }}</span>

                    </p>

                    <p class="mb-2">

                        <strong style="color: #0f974b; min-width: 120px; display: inline-block;">Department:</strong>

                        <span style="color: #333;">Customer Support</span>

                    </p>

                    <p class="mb-0">

                        <strong style="color: #0f974b; min-width: 120px; display: inline-block;">Status:</strong>

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



            <div class="col-md-4 border-right px-4" style="border-color: rgba(244, 158, 56, 0.3) !important;">

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
                                id="active-agents">{{ count($availableAgents) }}/{{ $totalAgentCount }}</span>

                        </div>

                        {{-- <div class="progress" style="height: 8px;">

                                    <div class="progress-bar"

                                        style="background-color: #0f974b; width: {{ $availableAgentsCount > 0 ? ($availableAgentsCount / $totalAgentCount) * 100 : '--' }}%;">

                                    </div>

                                </div> --}}

                    </div>

                    {{-- <div class="mb-3">

                                <div class="d-flex justify-content-between mb-1">

                                    <span style="color: #0f974b;">

                                        <i class="fas fa-phone-alt mr-1"></i>Calls in Progress:

                                    </span>

                                    <span

                                        style="color: #333;">{{ $activeCalls }}/{{ $availableAgentsCount }}</span>

                                </div>

                                <div class="progress" style="height: 8px;">

                                    <div class="progress-bar"

                                        style="background-color: #28a745; width: {{ $availableAgentsCount > 0 ? ($activeCalls / $availableAgentsCount) * 100 : '--' }}%;">

                                    </div>

                                </div>

                            </div> --}}

                    <div>

                        <div class="d-flex justify-content-between mb-1">

                            <span style="color: #0f974b;">

                                <i class="fas fa-hourglass-half mr-1"></i>Queue Wait
                                Time:

                            </span>

                            <span style="color: #333;">--:--</span>

                        </div>

                        <div class="progress" style="height: 8px;">

                            <div class="progress-bar" style="background-color: #fd7e14; width: 65%;">

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>





    </div>




    {{-- Agent Activity Card --}}
    <div class="card mb-5 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title mb-0">Agent Activity Overview</h5>

                <button wire:click="probAgents" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-sync" wire:loading.remove wire:target="probAgents"></i>
                    <i class="fas fa-spinner fa-spin" wire:loading wire:target="probAgents"></i>
                    Refresh Status
                </button>
            </div>

            <div class="row g-4">
                @forelse ($availableAgents as $agent)
                    @php
                        // Find the status info for the current agent from the $agentStatuses array
                        $statusInfo = collect($agentStatuses)->firstWhere('agent_num', $agent->endpoint);

                        // Set default values
                        $badgeClass = 'bg-secondary';
                        $badgeText = 'Unknown';
                        $iconClass = 'fa-question-circle text-secondary';

                        if ($statusInfo) {
                            if ($statusInfo['action_taken'] === 'error') {
                                $badgeClass = 'bg-warning text-dark';
                                $badgeText = 'Error';
                                $iconClass = 'fa-exclamation-triangle text-warning';
                            } elseif ($statusInfo['api_status'] === true) {
                                $badgeClass = 'bg-success';
                                $badgeText = $agent->status ?? 'IDLE';
                                $iconClass = 'fa-user-circle text-success';
                            } elseif ($statusInfo['api_status'] === false) {
                                // The API check found the agent is offline, even if the DB said they were logged in
                                $badgeClass = 'bg-danger';
                                $badgeText = 'OFFLINE';
                                $iconClass = 'fa-user-alt-slash text-danger';
                            }
                        }
                    @endphp

                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-light shadow-sm" data-endpoint="{{ $agent->endpoint }}">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i id="icon-{{ $agent->endpoint }}" class="fas {{ $iconClass }} fa-3x"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $agent->name ?? 'Unnamed Agent' }}</h6>

                                <span id="badge-{{ $agent->endpoint }}" class="badge {{ $badgeClass }} mb-2">
                                    {{ $badgeText }}
                                </span>

                                <ul class="list-unstyled small text-muted">
                                    <li>
                                        <i class="fas fa-phone-alt me-2 text-success"></i>
                                        {{ $agent->endpoint ?? 'N/A' }}
                                    </li>
                                    <li>
                                        <i class="fas fa-clock me-2 text-secondary"></i>
                                        <span id="duration-{{ $agent->endpoint }}"
                                            class="call-duration">00:00:00</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No active agents found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>


@push('custom-scripts')
    <script>
        window.addEventListener('livewire:load', () => {
            // --- GLOBAL STATE ---
            let socket = null; // Global variable to hold the single WebSocket connection
            let reconnectInterval; // Variable to hold the interval timer

            // Note: The original code used `reconnectTimeout` which is less ideal for continuous retries.
            // We will switch to a central `setInterval` loop at the end.

            // --- UTILITY FUNCTIONS ---

            function formatDuration(seconds) {
                const h = String(Math.floor(seconds / 3600)).padStart(2, '0');
                const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
                const s = String(seconds % 60).padStart(2, '0');
                return `${h}:${m}:${s}`;
            }

            function updateCallDurations() {
                document.querySelectorAll('.call-duration[data-started-at]').forEach(durationElem => {
                    const startedAtIso = durationElem.dataset.startedAt;
                    const startedAt = new Date(startedAtIso);
                    const now = new Date();
                    const elapsedSeconds = Math.floor((now - startedAt) / 1000);
                    // Only update if time is positive (prevents negative timer issues)
                    if (elapsedSeconds >= 0) {
                        durationElem.textContent = formatDuration(elapsedSeconds);
                    }
                });
            }

            // Start the timer update loop
            setInterval(updateCallDurations, 1000);

            function cleanEndpoint(rawEndpoint) {
                if (!rawEndpoint) return null;
                // Specifically handle PJSIP/ endpoint format
                if (rawEndpoint.startsWith('PJSIP/')) {
                    const parts = rawEndpoint.split('/');
                    if (parts.length > 1) {
                        const endpointAndId = parts[1];
                        const endpointParts = endpointAndId.split('-');
                        return endpointParts[0]; // Returns '6004' from 'PJSIP/6004-0000051f'
                    }
                }
                // For other types or if no specific format, return as is
                return rawEndpoint;
            }

            // --- WEBSOCKET CONNECTION FUNCTION ---

            function reConnect() {
                const ws_address_elem = document.getElementById("ws_endpoint");
                const ws_socket_elem = document.getElementById("ws-info");

                // --- CRITICAL FIX 1: Prevent duplicate connections ---
                // If socket is already open or connecting, do nothing.
                if (socket && (socket.readyState === WebSocket.OPEN || socket.readyState === WebSocket
                    .CONNECTING)) {
                    return;
                }

                const ws_url = ws_address_elem && ws_address_elem.value ?
                    ws_address_elem.value :
                    "ws://10.44.0.56:8001/ws";

                console.log("WebSocket attempting connection to:", ws_url);

                // Create new socket and assign it to the global variable
                socket = new WebSocket(ws_url);

                // --- LISTENERS ARE ATTACHED ONLY ONCE PER NEW SOCKET INSTANCE ---

                socket.addEventListener("open", (event) => {
                    console.log("WebSocket connection opened:", ws_url);
                    if (ws_socket_elem) {
                        ws_socket_elem.classList.remove("badge-danger");
                        ws_socket_elem.classList.add("badge-success");
                        ws_socket_elem.textContent = "Connected";
                    }
                    socket.send("Hello Server!");
                    Livewire.emit('refreshComponent');
                });

                socket.addEventListener("message", (event) => {
                    try {
                        const data = JSON.parse(event.data);
                        console.log("Received WebSocket message:", data);

                        // Helper to get endpoint from various data structures
                        const getEndpointFromChannelName = (channelName) => {
                            if (!channelName) return null;
                            const parts = channelName.split('/');
                            if (parts.length > 1) {
                                const endpointAndId = parts[1];
                                const endpointParts = endpointAndId.split('-');
                                return endpointParts[0];
                            }
                            return null;
                        };

                        if (data.type === "StasisStart") {
                            const rawEndpoint = data.args && data.args[1] ? data.args[1] : null;
                            const endpoint = cleanEndpoint(rawEndpoint);

                            if (!endpoint) {
                                console.warn("StasisStart: No clean endpoint found from args[1].");
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                badge.classList.remove("bg-danger", "bg-warning", "text-dark");
                                badge.classList.add("bg-success");
                                badge.textContent = "ON_A_CALL";
                            }
                            if (icon) {
                                icon.classList.remove("text-danger", "text-warning", "fa-user-circle",
                                    "fa-bell");
                                icon.classList.add("text-success", "fa-phone-alt");
                            }
                            if (durationElem) {
                                durationElem.dataset.startedAt = new Date().toISOString();
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "ChannelStateChange" && data.channel && data.channel
                            .state === "Ringing") {
                            const endpoint = getEndpointFromChannelName(data.channel.name);

                            if (!endpoint) {
                                console.warn(
                                    "ChannelStateChange (Ringing): No endpoint found from channel.name."
                                    );
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                badge.classList.remove("bg-success", "bg-danger");
                                badge.classList.add("bg-warning", "text-dark");
                                badge.textContent = "RINGING";
                            }
                            if (icon) {
                                icon.classList.remove("text-success", "text-danger", "fa-phone-alt",
                                    "fa-user-circle");
                                icon.classList.add("text-warning", "fa-bell");
                            }
                            if (durationElem) {
                                delete durationElem.dataset.startedAt;
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "StasisEnd" || data.type === "ChannelDestroyed") {
                            // StasisEnd/ChannelDestroyed indicate the end of the call.
                            const endpoint = getEndpointFromChannelName(data.channel?.name);

                            if (!endpoint) {
                                console.warn(`${data.type}: No clean endpoint found from channel.name.`);
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                badge.classList.remove("bg-success", "bg-warning", "text-dark");
                                badge.classList.add("bg-danger");
                                badge.textContent = "AVAILABLE";
                            }
                            if (icon) {
                                icon.classList.remove("text-success", "text-warning", "fa-phone-alt",
                                    "fa-bell");
                                icon.classList.add("text-danger", "fa-user-circle"); // Back to user icon
                            }
                            if (durationElem) {
                                delete durationElem.dataset.startedAt;
                                durationElem.textContent = "00:00:00";
                            }
                        }
                    } catch (e) {
                        console.error("Failed to parse WebSocket message data or process event:", e, event
                            .data);
                    }
                });

                socket.addEventListener("error", (event) => {
                    console.error("WebSocket error:", event);
                    if (ws_socket_elem) {
                        ws_socket_elem.classList.remove("badge-success");
                        ws_socket_elem.classList.add("badge-danger");
                        ws_socket_elem.textContent = "Disconnected (Error)";
                    }
                    // CRITICAL FIX 2: Removed recursive setTimeout here
                });

                socket.addEventListener("close", (event) => {
                    console.warn("WebSocket connection closed:", event);
                    if (ws_socket_elem) {
                        ws_socket_elem.classList.remove("badge-success");
                        ws_socket_elem.classList.add("badge-danger");
                        ws_socket_elem.textContent = "Disconnected";
                    }
                    // CRITICAL FIX 2: Removed recursive setTimeout here
                });
            }

            // --- CONNECTION MANAGEMENT START ---

            // 1. Initial WebSocket Connection
            reConnect();

            // 2. CRITICAL FIX 3: Centralized Reconnection Loop
            // Checks every 5 seconds if the socket needs to be reconnected.
            reconnectInterval = setInterval(() => {
                // Reconnect if socket is not initialized, or is closed/closing.
                if (!socket || socket.readyState === WebSocket.CLOSED || socket.readyState === WebSocket
                    .CLOSING) {
                    reConnect();
                }
            }, 5000); // Check every 5 seconds

            // --- CONNECTION MANAGEMENT END ---
        });
    </script>
@endpush

<div class="container mt-4">
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


        </div>


    </div>




    <!-- Active Agent Monitoring with Icons -->
    {{-- <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Active Agents</h5>
            <div class="row text-center">
                <!-- Agent 1 -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Jane Smith</h6>
                            <p><i class="fas fa-phone-alt text-success"></i></p>
                            <span class="badge badge-success">Active</span>
                            <p class="mt-2"><strong>Caller:</strong> +1234567890</p>
                            <p><strong>Duration:</strong> 00:07:30</p>
                        </div>
                    </div>
                </div>

                <!-- Agent 2 -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Michael Johnson</h6>
                            <p><i class="fas fa-pause-circle text-warning"></i></p>
                            <span class="badge badge-warning">On Hold</span>
                            <p class="mt-2"><strong>Caller:</strong> +9876543210</p>
                            <p><strong>Duration:</strong> 00:04:50</p>
                        </div>
                    </div>
                </div>

                <!-- Agent 3 -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Emily Davis</h6>
                            <p><i class="fas fa-exclamation-triangle text-danger"></i></p>
                            <span class="badge badge-danger">Disconnected</span>
                            <p class="mt-2"><strong>Caller:</strong> +1122334455</p>
                            <p><strong>Duration:</strong> 00:03:25</p>
                        </div>
                    </div>
                </div>

                <!-- Agent 4 -->
                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h6>Sarah Lee</h6>
                            <p><i class="fas fa-phone-slash text-muted"></i></p>
                            <span class="badge badge-secondary">Unavailable</span>
                            <p class="mt-2"><strong>Caller:</strong> N/A</p>
                            <p><strong>Duration:</strong> N/A</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="container mt-4">





        <div class="row g-4">
            <!-- Row 1 -->
            <div class="col-md-3">
                <!-- Agent 1 - Active -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-success mb-2"></i>
                        <h6 class="fw-bold">Alex Morgan</h6>
                        <span class="badge bg-success mb-2">Active</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-success"></i>+14155552678
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:08:12</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 2 - On Hold -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-warning mb-2"></i>
                        <h6 class="fw-bold">Brian Adams</h6>
                        <span class="badge bg-warning text-dark mb-2">On Hold</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-warning"></i>+19876543210
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:05:47</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 3 - Disconnected -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-danger mb-2"></i>
                        <h6 class="fw-bold">Catherine Lee</h6>
                        <span class="badge bg-danger mb-2">Disconnected</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-danger"></i>+12223334444
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:02:19</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 4 - Unavailable -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                        <h6 class="fw-bold">Daniel Kim</h6>
                        <span class="badge bg-secondary mb-2">Unavailable</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-slash me-1 text-muted"></i>N/A</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>N/A</p>
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="col-md-3">
                <!-- Agent 5 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-success mb-2"></i>
                        <h6 class="fw-bold">Ella Thompson</h6>
                        <span class="badge bg-success mb-2">Active</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-success"></i>+13134445566
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:06:30</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 6 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-warning mb-2"></i>
                        <h6 class="fw-bold">Tom Hardy</h6>
                        <span class="badge bg-warning text-dark mb-2">On Hold</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-warning"></i>+14678901234
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:04:11</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 7 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-danger mb-2"></i>
                        <h6 class="fw-bold">Mia Chen</h6>
                        <span class="badge bg-danger mb-2">Disconnected</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-danger"></i>+19874561230
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:01:56</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 8 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                        <h6 class="fw-bold">George Lin</h6>
                        <span class="badge bg-secondary mb-2">Unavailable</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-slash me-1 text-muted"></i>N/A</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>N/A</p>
                    </div>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="col-md-3">
                <!-- Agent 9 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-success mb-2"></i>
                        <h6 class="fw-bold">Natalie Young</h6>
                        <span class="badge bg-success mb-2">Active</span>
                        <p class="mb-1 small text-muted"><i
                                class="fas fa-phone-alt me-1 text-success"></i>+10987654321</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:09:05</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 10 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-warning mb-2"></i>
                        <h6 class="fw-bold">Liam Turner</h6>
                        <span class="badge bg-warning text-dark mb-2">On Hold</span>
                        <p class="mb-1 small text-muted"><i
                                class="fas fa-phone-alt me-1 text-warning"></i>+12345678123</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:03:45</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 11 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-danger mb-2"></i>
                        <h6 class="fw-bold">Olivia Perez</h6>
                        <span class="badge bg-danger mb-2">Disconnected</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-danger"></i>+13579135791
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:02:33</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 12 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                        <h6 class="fw-bold">Marcus Wright</h6>
                        <span class="badge bg-secondary mb-2">Unavailable</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-slash me-1 text-muted"></i>N/A</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>N/A</p>
                    </div>
                </div>
            </div>

            <!-- Row 4 -->
            <div class="col-md-3">
                <!-- Agent 13 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-success mb-2"></i>
                        <h6 class="fw-bold">Julia Stokes</h6>
                        <span class="badge bg-success mb-2">Active</span>
                        <p class="mb-1 small text-muted"><i
                                class="fas fa-phone-alt me-1 text-success"></i>+15550111222</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:07:15</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 14 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-warning mb-2"></i>
                        <h6 class="fw-bold">Derek Mason</h6>
                        <span class="badge bg-warning text-dark mb-2">On Hold</span>
                        <p class="mb-1 small text-muted"><i
                                class="fas fa-phone-alt me-1 text-warning"></i>+14440999888</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:05:00</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 15 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-danger mb-2"></i>
                        <h6 class="fw-bold">Ethan Brooks</h6>
                        <span class="badge bg-danger mb-2">Disconnected</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-alt me-1 text-danger"></i>+1999888777
                        </p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>00:01:10</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <!-- Agent 16 -->
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="fas fa-user-circle fa-3x text-muted mb-2"></i>
                        <h6 class="fw-bold">Sophie Bell</h6>
                        <span class="badge bg-secondary mb-2">Unavailable</span>
                        <p class="mb-1 small text-muted"><i class="fas fa-phone-slash me-1 text-muted"></i>N/A</p>
                        <p class="small text-muted"><i class="fas fa-clock me-1"></i>N/A</p>
                    </div>
                </div>
            </div>
        </div>





        <!-- WebSocket Data (For System Monitoring) -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">WebSocket Data</h5>
                <pre id="json-data">[WebSocket Data Placeholder]</pre>
            </div>
        </div>
    </div> --}}

    <div class="card mb-5 shadow">
        <div class="card-body">
            <h5 class="card-title mb-4">Agent Activity Overview</h5>
            <div class="row g-4">
                @foreach ($availableAgents as $agent)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100 border-light shadow-sm" data-endpoint="{{ $agent->endpoint }}">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i id="icon-{{ $agent->endpoint }}" class="fas fa-user-circle fa-3x text-success"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $agent->name ?? 'Unnamed Agent' }}</h6>
                                <span id="badge-{{ $agent->endpoint }}" class="badge bg-success mb-2">
                                    {{ $agent->state ?? 'Unknown' }}
                                </span>
                                <ul class="list-unstyled small text-muted">
                                    <li>
                                        <i class="fas fa-phone-alt me-2 text-success"></i>
                                        {{ $agent->endpoint ?? 'N/A' }}
                                    </li>
                                    <li>
                                        <i class="fas fa-clock me-2 text-secondary"></i>
                                        <span id="duration-{{ $agent->endpoint }}" class="call-duration">00:00:00</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>


</div>

@push('custom-scripts')
    <script>
        window.addEventListener('livewire:load', () => {
            const apiUrl = "https://ivr.zesco.co.zm:8089/ari/bridges?api_key=asterisk:asterisk";

            let reconnectTimeout;

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
                    durationElem.textContent = formatDuration(elapsedSeconds);
                });
            }

            setInterval(updateCallDurations, 1000);

            function cleanEndpoint(rawEndpoint) {
                if (!rawEndpoint) return null;
                if (rawEndpoint.startsWith('PJSIP/')) {
                    return rawEndpoint.substring(6);
                }
                return rawEndpoint;
            }

            function reConnect() {
                clearTimeout(reconnectTimeout);

                const ws_address_elem = document.getElementById("ws_endpoint");
                const ws_socket_elem = document.getElementById("ws-info");

                const ws_url = ws_address_elem && ws_address_elem.value ? ws_address_elem.value : "ws://10.44.0.56:8001/ws";
                console.log("WebSocket attempting connection to:", ws_url);

                const socket = new WebSocket(ws_url);

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

                        const getCleanedEndpointFromAppData = (appData) => {
                            if (!appData) return null;
                            const parts = appData.split(',');
                            const rawEndpoint = parts.length > 2 ? parts[2] : null;
                            return cleanEndpoint(rawEndpoint);
                        };

                        if (data.type === "StasisStart") {
                            const rawEndpoint = data.args && data.args[1] ? data.args[1] : null;
                            const endpoint = cleanEndpoint(rawEndpoint);

                            if (!endpoint) {
                                console.warn("StasisStart: No clean endpoint found from args[1]. Raw:", rawEndpoint);
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                // On Call: Green badge
                                badge.classList.remove("bg-danger"); // Remove old color
                                badge.classList.add("bg-success");  // Add new color
                                badge.textContent = "ON_A_CALL";
                            }
                            if (icon) {
                                // On Call: Green icon
                                icon.classList.remove("text-danger"); // Remove old color
                                icon.classList.add("text-success");  // Add new color
                            }
                            if (durationElem) {
                                durationElem.dataset.startedAt = new Date().toISOString();
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "StasisEnd") {
                            const endpoint = getCleanedEndpointFromAppData(data.channel?.dialplan?.app_data);

                            if (!endpoint) {
                                console.warn("StasisEnd: No clean endpoint found from channel.dialplan.app_data.");
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                // Available: Red badge
                                badge.classList.remove("bg-success"); // Remove old color
                                badge.classList.add("bg-danger");   // Add new color
                                badge.textContent = "AVAILABLE";
                            }
                            if (icon) {
                                // Available: Red icon
                                icon.classList.remove("text-success"); // Remove old color
                                icon.classList.add("text-danger");    // Add new color
                            }
                            if (durationElem) {
                                delete durationElem.dataset.startedAt;
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "Dial" || data.type === "Answer" || data.type === "NoAnswer") {
                            // ... (Your existing placeholder logic if any)
                        }
                    } catch (e) {
                        console.error("Failed to parse WebSocket message data or process event:", e, event.data);
                    }
                });

                socket.addEventListener("error", (event) => {
                    console.error("WebSocket error:", event);
                    if (ws_socket_elem) {
                        ws_socket_elem.classList.remove("badge-success");
                        ws_socket_elem.classList.add("badge-danger");
                        ws_socket_elem.textContent = "Disconnected (Error)";
                    }
                    reconnectTimeout = setTimeout(reConnect, 5000);
                });

                socket.addEventListener("close", (event) => {
                    console.warn("WebSocket connection closed:", event);
                    if (ws_socket_elem) {
                        ws_socket_elem.classList.remove("badge-success");
                        ws_socket_elem.classList.add("badge-danger");
                        ws_socket_elem.textContent = "Disconnected";
                    }
                    reconnectTimeout = setTimeout(reConnect, 5000);
                });
            }

            reConnect();
        });
    </script>
@endpush
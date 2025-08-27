<div class="container mt-4">
    {{-- Supervisor Info and System Status columns remain the same --}}
    <div class="card-body" style="background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);">
        <div class="row">
            {{-- Column 1: Supervisor Information --}}
            <div class="col-md-4 border-right pr-4" style="border-color: rgba(244, 158, 56, 0.3) !important;">
                {{-- ... your supervisor info code ... --}}
            </div>

            {{-- Column 2: System Status --}}
            <div class="col-md-4 border-right px-4" style="border-color: rgba(244, 158, 56, 0.3) !important;">
                {{-- ... your system status code ... --}}
            </div>

            {{-- Column 3: Team Overview --}}
            <div class="col-md-4 pl-4">
                {{-- ... your team overview code ... --}}
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
                                $badgeText = 'IDLE';
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
                                        <span id="duration-{{ $agent->endpoint }}" class="call-duration">00:00:00</span>
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
                // Specifically handle PJSIP/ endpoint format
                if (rawEndpoint.startsWith('PJSIP/')) {
                    const parts = rawEndpoint.split('/');
                    if (parts.length > 1) {
                        const endpointAndId = parts[1];
                        const endpointParts = endpointAndId.split('-');
                        return endpointParts[0]; // Returns '6004' from 'PJSIP/6004-0000051f'
                    }
                }
                // For other types or if no specific format, return as is (or handle as needed)
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
                        console.log("Received WebSocket message:", data); // Log all incoming messages for debugging

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
                                console.warn("StasisStart: No clean endpoint found from args[1]. Raw:", rawEndpoint);
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                badge.classList.remove("bg-danger", "bg-warning");
                                badge.classList.add("bg-success");
                                badge.textContent = "ON_A_CALL";
                            }
                            if (icon) {
                                icon.classList.remove("text-danger", "text-warning");
                                icon.classList.add("text-success");
                                icon.classList.remove("fa-user-circle"); // Remove default user icon
                                icon.classList.add("fa-phone-alt"); // Add phone icon
                            }
                            if (durationElem) {
                                durationElem.dataset.startedAt = new Date().toISOString();
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "ChannelStateChange" && data.channel && data.channel.state === "Ringing") {
                            // Extract endpoint from channel.name for Ringing state
                            const endpoint = getEndpointFromChannelName(data.channel.name);

                            if (!endpoint) {
                                console.warn("ChannelStateChange (Ringing): No endpoint found from channel.name. Raw:", data.channel.name);
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            // For ringing, we don't necessarily start a duration timer yet,
                            // but we can ensure it's reset or just left as 00:00:00
                            const durationElem = document.getElementById(`duration-${endpoint}`);


                            if (badge) {
                                // Ringing: Orange/Warning badge
                                badge.classList.remove("bg-success", "bg-danger");
                                badge.classList.add("bg-warning", "text-dark"); // text-dark for visibility on warning background
                                badge.textContent = "RINGING";
                            }
                            if (icon) {
                                // Ringing: Orange/Warning icon, possibly a ringing specific icon
                                icon.classList.remove("text-success", "text-danger", "fa-phone-alt", "fa-user-circle");
                                icon.classList.add("text-warning", "fa-bell"); // FontAwesome bell icon for ringing
                            }
                             if (durationElem) {
                                // For ringing, typically the call duration hasn't started, or it's a new "ringing" phase
                                delete durationElem.dataset.startedAt; // Remove any previous started time
                                durationElem.textContent = "00:00:00";
                            }

                        } else if (data.type === "StasisEnd") {
                            // StasisEnd often indicates the end of a call.
                            // The `app_data` might contain the endpoint, or you might need to rely on `channel.name`
                            // For StasisEnd, `channel.dialplan.app_data` format may vary, so let's stick to channel.name for consistency if possible.
                            const endpoint = getEndpointFromChannelName(data.channel?.name);


                            if (!endpoint) {
                                console.warn("StasisEnd: No clean endpoint found from channel.name.");
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                // Available (after call): Red badge
                                badge.classList.remove("bg-success", "bg-warning", "text-dark"); // Ensure text-dark is removed
                                badge.classList.add("bg-danger");
                                badge.textContent = "AVAILABLE";
                            }
                            if (icon) {
                                // Available: Red user icon (or default user icon)
                                icon.classList.remove("text-success", "text-warning", "fa-phone-alt", "fa-bell");
                                icon.classList.add("text-danger", "fa-user-circle"); // Back to user icon
                            }
                            if (durationElem) {
                                delete durationElem.dataset.startedAt;
                                durationElem.textContent = "00:00:00";
                            }
                        }else if (data.type === "ChannelDestroyed") {
                            // StasisEnd often indicates the end of a call.
                            // The `app_data` might contain the endpoint, or you might need to rely on `channel.name`
                            // For StasisEnd, `channel.dialplan.app_data` format may vary, so let's stick to channel.name for consistency if possible.
                            const endpoint = getEndpointFromChannelName(data.channel?.name);


                            if (!endpoint) {
                                console.warn("StasisEnd: No clean endpoint found from channel.name.");
                                return;
                            }

                            const badge = document.getElementById(`badge-${endpoint}`);
                            const icon = document.getElementById(`icon-${endpoint}`);
                            const durationElem = document.getElementById(`duration-${endpoint}`);

                            if (badge) {
                                // Available (after call): Red badge
                                badge.classList.remove("bg-success", "bg-warning", "text-dark"); // Ensure text-dark is removed
                                badge.classList.add("bg-danger");
                                badge.textContent = "AVAILABLE";
                            }
                            if (icon) {
                                // Available: Red user icon (or default user icon)
                                icon.classList.remove("text-success", "text-warning", "fa-phone-alt", "fa-bell");
                                icon.classList.add("text-danger", "fa-user-circle"); // Back to user icon
                            }
                            if (durationElem) {
                                delete durationElem.dataset.startedAt;
                                durationElem.textContent = "00:00:00";
                            }
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
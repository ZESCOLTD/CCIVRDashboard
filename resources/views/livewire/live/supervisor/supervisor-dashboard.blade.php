<div class="container mt-4">
    <!-- Supervisor Information and Status -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="card-title">Supervisor Information</h5>
                    <p><strong>Supervisor Name:</strong> John Doe</p>
                    <p><strong>Supervisor ID:</strong> 12345</p>
                    <p><strong>Status:</strong> <span class="badge badge-success">Online</span></p>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">System Status</h5>
                    <label class="text-info">Recorder Websocket:</label>
                    <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                    <span id="ws-info" class="badge badge-success">Connected</span>
                    <br>
                    <label class="text-info">Recorder Rest Interface:</label>
                    <input class="form-control text-success" type="text" id="api_endpoint"
                        value='{{ $api_server }}'>
                </div>
                <div class="col-md-4">
                    <h5 class="card-title">Current Team Overview</h5>
                    <p><strong>Active Agents:</strong> 5</p>
                    <p><strong>Total Calls in Progress:</strong> 3</p>
                    <p><strong>Longest Call Duration:</strong> 00:12:45</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Overview -->
    <div class="row">
        <div class="col-md-3">
            <div class="info-box bg-primary">
                <span class="info-box-icon"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Agents</span>
                    <span class="info-box-number">15</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-phone-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Calls</span>
                    <span class="info-box-number">10</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Calls in Queue</span>
                    <span class="info-box-number">5</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Average Wait Time</span>
                    <span class="info-box-number">01:30</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graph Placeholders for Supervisory Metrics -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Team Performance (Last 7 Days)</h5>
                    <div style="height: 300px; background-color: #f2f2f2;">
                        <!-- Placeholder for Team Performance Graph -->
                        <p class="text-center text-muted">[Graph Placeholder]</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Agent Availability</h5>
                    <div style="height: 300px; background-color: #f2f2f2;">
                        <!-- Placeholder for Agent Availability Graph -->
                        <p class="text-center text-muted">[Graph Placeholder]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call Control Panel for Supervisory Actions -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4>Manage Sessions</h4>
                    <select class="form-control" wire:model="selectedSession" wire:change="changeSession">
                        <option value="">Select Session</option>
                        @foreach ($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-danger btn-block" wire:click.prevent="endCall">End All Calls</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-secondary btn-block" wire:click.prevent="transferCall">Transfer All
                        Calls</button>
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

    <div class="container mt-4">
        <!-- Supervisor Information and Status -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5 class="card-title">Supervisor Information</h5>
                        <p><strong>Supervisor Name:</strong> John Doe</p>
                        <p><strong>Supervisor ID:</strong> 12345</p>
                        <p><strong>Status:</strong> <span class="badge badge-success">Online</span></p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="card-title">System Status</h5>
                        <label class="text-info">Recorder Websocket:</label>
                        <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                        <span id="ws-info" class="badge badge-success">Connected</span>
                        <br>
                        <label class="text-info">Recorder Rest Interface:</label>
                        <input class="form-control text-success" type="text" id="api_endpoint"
                            value='{{ $api_server }}'>
                    </div>
                    <div class="col-md-4">
                        <h5 class="card-title">Current Team Overview</h5>
                        <p><strong>Active Agents:</strong> 5</p>
                        <p><strong>Total Calls in Progress:</strong> 3</p>
                        <p><strong>Longest Call Duration:</strong> 00:12:45</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Overview -->
        <div class="row">
            <div class="col-md-3">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Agents</span>
                        <span class="info-box-number">15</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-phone-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active Calls</span>
                        <span class="info-box-number">10</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Calls in Queue</span>
                        <span class="info-box-number">5</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-warning">
                    <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Average Wait Time</span>
                        <span class="info-box-number">01:30</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graph Placeholders for Supervisory Metrics -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Team Performance (Last 7 Days)</h5>
                        <div style="height: 300px; background-color: #f2f2f2;">
                            <!-- Placeholder for Team Performance Graph -->
                            <p class="text-center text-muted">[Graph Placeholder]</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Agent Availability</h5>
                        <div style="height: 300px; background-color: #f2f2f2;">
                            <!-- Placeholder for Agent Availability Graph -->
                            <p class="text-center text-muted">[Graph Placeholder]</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call Control Panel for Supervisory Actions -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <h4>Manage Sessions</h4>
                        <select class="form-control" wire:model="selectedSession" wire:change="changeSession">
                            <option value="">Select Session</option>
                            @foreach ($sessions as $session)
                                <option value="{{ $session->id }}">{{ $session->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-danger btn-block" wire:click.prevent="endCall">End All Calls</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-secondary btn-block" wire:click.prevent="transferCall">Transfer All
                            Calls</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Agent Monitoring with Icons -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Active Agents</h5>
                <div class="row">
                    <!-- Agent 1 -->
                    <div class="col-md-4">
                        <div class="agent-card mb-3 p-3 border rounded">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user fa-2x mr-3 text-success"></i>
                                <div>
                                    <h6>Jane Smith</h6>
                                    <p><i class="fas fa-phone-alt"></i> +1234567890</p>
                                    <p><i class="fas fa-clock"></i> 00:07:30</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="mr-2"><i class="fas fa-check-circle text-success"></i> Active</span>
                            </div>
                        </div>
                    </div>
                    <!-- Agent 2 -->
                    <div class="col-md-4">
                        <div class="agent-card mb-3 p-3 border rounded">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user fa-2x mr-3 text-warning"></i>
                                <div>
                                    <h6>Michael Johnson</h6>
                                    <p><i class="fas fa-phone-alt"></i> +9876543210</p>
                                    <p><i class="fas fa-clock"></i> 00:04:50</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="mr-2"><i class="fas fa-pause-circle text-warning"></i> On Hold</span>
                            </div>
                        </div>
                    </div>
                    <!-- Agent 3 -->
                    <div class="col-md-4">
                        <div class="agent-card mb-3 p-3 border rounded">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user fa-2x mr-3 text-danger"></i>
                                <div>
                                    <h6>Emily Davis</h6>
                                    <p><i class="fas fa-phone-alt"></i> +1122334455</p>
                                    <p><i class="fas fa-clock"></i> 00:03:25</p>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="mr-2"><i class="fas fa-times-circle text-danger"></i>
                                    Disconnected</span>
                            </div>
                        </div>
                    </div>
                    <!-- Add more agents as needed -->
                </div>
            </div>
        </div>


        <!-- Active Agent Monitoring with Icons (30 Agents) -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Active Agents</h5>
                <div class="row text-center">
                    <!-- Agent 1 -->
                    <div class="col-md-3 mb-3">
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
                    <div class="col-md-3 mb-3">
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
                    <div class="col-md-3 mb-3">
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
                    <div class="col-md-3 mb-3">
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

                    <!-- Agent 5 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>John Doe</h6>
                                <p><i class="fas fa-phone-alt text-success"></i></p>
                                <span class="badge badge-success">Active</span>
                                <p class="mt-2"><strong>Caller:</strong> +9988776655</p>
                                <p><strong>Duration:</strong> 00:06:10</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 6 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Mary Johnson</h6>
                                <p><i class="fas fa-pause-circle text-warning"></i></p>
                                <span class="badge badge-warning">On Hold</span>
                                <p class="mt-2"><strong>Caller:</strong> +1029384756</p>
                                <p><strong>Duration:</strong> 00:05:20</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 7 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Lisa White</h6>
                                <p><i class="fas fa-phone-slash text-muted"></i></p>
                                <span class="badge badge-secondary">Unavailable</span>
                                <p class="mt-2"><strong>Caller:</strong> N/A</p>
                                <p><strong>Duration:</strong> N/A</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 8 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Chris Evans</h6>
                                <p><i class="fas fa-exclamation-triangle text-danger"></i></p>
                                <span class="badge badge-danger">Disconnected</span>
                                <p class="mt-2"><strong>Caller:</strong> +5647382910</p>
                                <p><strong>Duration:</strong> 00:02:50</p>
                            </div>
                        </div>
                    </div>

                    <!-- Repeat similar structure for Agents 9 to 30 -->

                    <!-- Agent 9 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Paul Walker</h6>
                                <p><i class="fas fa-phone-alt text-success"></i></p>
                                <span class="badge badge-success">Active</span>
                                <p class="mt-2"><strong>Caller:</strong> +1144778899</p>
                                <p><strong>Duration:</strong> 00:04:45</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 10 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Susan Smith</h6>
                                <p><i class="fas fa-pause-circle text-warning"></i></p>
                                <span class="badge badge-warning">On Hold</span>
                                <p class="mt-2"><strong>Caller:</strong> +9988776655</p>
                                <p><strong>Duration:</strong> 00:04:30</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 11 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Peter Parker</h6>
                                <p><i class="fas fa-phone-slash text-muted"></i></p>
                                <span class="badge badge-secondary">Unavailable</span>
                                <p class="mt-2"><strong>Caller:</strong> N/A</p>
                                <p><strong>Duration:</strong> N/A</p>
                            </div>
                        </div>
                    </div>

                    <!-- Agent 12 -->
                    <div class="col-md-3 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h6>Natasha Romanoff</h6>
                                <p><i class="fas fa-exclamation-triangle text-danger"></i></p>
                                <span class="badge badge-danger">Disconnected</span>
                                <p class="mt-2"><strong>Caller:</strong> +2233445566</p>
                                <p><strong>Duration:</strong> 00:05:10</p>
                            </div>
                        </div>
                    </div>

                    <!-- ... Continue for Agents 13 through 30 -->

                </div>
            </div>
        </div>


        <!-- Incoming Call Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h4>Incoming Call</h4>
            </div>
            <div class="card-body">
                <pre id="json-call-data">[Call Data Placeholder]</pre>
            </div>
        </div>

        <!-- Recent Calls -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Recent Calls</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Caller</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>+9876543210</td>
                            <td>00:05:20</td>
                        </tr>
                        <tr>
                            <td>+1122334455</td>
                            <td>00:02:45</td>
                        </tr>
                        <tr>
                            <td>+9988776655</td>
                            <td>00:04:10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- WebSocket Data (For System Monitoring) -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">WebSocket Data</h5>
                <pre id="json-data">[WebSocket Data Placeholder]</pre>
            </div>
        </div>
    </div>

    <!-- Agent Login/Logout Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Agent Login/Logout</h5>

            <!-- Login/Logout Form -->
            <div class="row">
                <div class="col-md-6">
                    <label for="agentId">Agent ID:</label>
                    <input type="text" id="agentId" class="form-control" placeholder="Enter Agent ID">
                </div>
                <div class="col-md-6">
                    <label for="agentName">Agent Name:</label>
                    <input type="text" id="agentName" class="form-control" placeholder="Enter Agent Name">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <button class="btn btn-success btn-block" id="loginBtn" onclick="logInAgent()">Log In</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger btn-block" id="logoutBtn" onclick="logOutAgent()">Log Out</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Multiple Agent Login/Logout Section -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Multiple Agent Login/Logout</h5>

            <!-- Select for multiple agents -->
            <div class="row">
                <div class="col-md-12">
                    <label for="agentSelect">Select Agents:</label>
                    <select id="agentSelect" class="form-control" multiple size="6"
                        onchange="updateSelectedAgents()">
                        <option value="1">John Doe (ID: 12345)</option>
                        <option value="2">Jane Smith (ID: 67890)</option>
                        <option value="3">Michael Johnson (ID: 54321)</option>
                        <option value="4">Emily Davis (ID: 98765)</option>
                        <option value="5">Chris Evans (ID: 11223)</option>
                        <option value="6">Natasha Romanoff (ID: 44556)</option>
                        <!-- Add more agents as needed -->
                    </select>
                    <small class="form-text text-muted">Hold down the Ctrl (Windows) or Command (Mac) key to select
                        multiple agents.</small>
                </div>
            </div>

            <!-- Display Selected Agents -->
            <div class="row mt-3">
                <div class="col-md-12">
                    <h6>Selected Agents:</h6>
                    <div id="selectedAgents" class="border p-2" style="min-height: 50px; background-color: #f9f9f9;">
                        <p class="text-muted">No agents selected yet.</p>
                    </div>
                </div>
            </div>

            <!-- Login/Logout Buttons -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <button class="btn btn-success btn-block" id="loginMultipleBtn"
                        onclick="logInMultipleAgents()">Log In Selected Agents</button>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-danger btn-block" id="logoutMultipleBtn"
                        onclick="logOutMultipleAgents()">Log Out Selected Agents</button>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('custom-scripts')
        <script>
            // WebSocket connection and event listeners as in the original code
            var ws_address = document.getElementById("ws_endpoint");
            var ws_socket = document.getElementById("ws-info");
            const preElement = document.getElementById('json-data');
            const incomingCall = document.getElementById('json-call-data');
            const socket = new WebSocket(ws_address.value);

            socket.addEventListener("open", (event) => {
                console.log("WebSocket connection opened: ", ws_address);
                ws_socket.classList.remove("badge-danger");
                ws_socket.classList.add("badge-success");
                ws_socket.textContent = "Connected ..";
                socket.send("Hello Server!");
            });

            socket.addEventListener("message", (event) => {
                preElement.style.fontSize = '12px';
                var data = JSON.parse(event.data);

                if (data.type == "StasisStart") {
                    incomingCall.innerHTML = JSON.stringify(data.channel.caller, null, 4);
                }
                if (data.type == "StasisEnd") {
                    incomingCall.innerHTML = "";
                }
                preElement.innerHTML = JSON.stringify(data, null, 4);
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
        </script>

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
 --}}

    <!-- WebSocket Data (For System Monitoring) -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">WebSocket Data</h5>
            <pre id="json-data">[WebSocket Data Placeholder]</pre>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
        window.addEventListener('load', function () {
    // WebSocket connection and event listeners as in the original code
    var ws_address = document.getElementById("ws_endpoint");
    var ws_socket = document.getElementById("ws-info");
    const preElement = document.getElementById('json-data');
    const socket = new WebSocket(ws_address.value);

    // ws://127.0.0.1:8001/ws
    // const socket = new WebSocket("http://127.0.0.1:8001/ws");

    socket.addEventListener("open", (event) => {
        console.log("WebSocket connection opened: ", ws_address);
        ws_socket.classList.remove("badge-danger");
        ws_socket.classList.add("badge-success");
        ws_socket.textContent = "Connected ..";
        socket.send("Hello Server!");
    });

    socket.addEventListener("message", (event) => {
        preElement.style.fontSize = '12px';
        var data = JSON.parse(event.data);
        preElement.innerHTML = JSON.stringify(data, null, 4);
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

})
</script>
@endpush


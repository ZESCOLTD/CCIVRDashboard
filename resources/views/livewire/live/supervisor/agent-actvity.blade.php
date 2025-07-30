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
                        <div class="card h-100 border-light shadow-sm">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-user-circle fa-3x text-success"></i>
                                </div>
                                <h6 class="fw-bold mb-1">{{ $agent->name ?? 'Unnamed Agent' }}</h6>
                                <span class="badge bg-success mb-2">
                                    {{ $agent->state ?? 'Unknown' }}
                                </span>
                                <ul class="list-unstyled small text-muted">
                                    <li>
                                        <i class="fas fa-phone-alt me-2 text-success"></i>
                                        {{ $agent->endpoint ?? 'N/A' }}
                                    </li>
                                    <li>
                                        <i class="fas fa-clock me-2 text-secondary"></i>
                                        {{ $agent->duration ?? '00:00:00' }}
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






            // WebSocket connection and event listeners as in the original code

            // ws://127.0.0.1:8001/ws
            // const socket = new WebSocket("http://127.0.0.1:8001/ws");

            function reConnect() {

                var ws_address = document.getElementById("ws_endpoint");
                var ws_socket = document.getElementById("ws-info");
                console.log("WebSocket address:", ws_address.value);


                // const socket = new WebSocket(ws_address.value);
                const socket = new WebSocket("ws://10.44.0.56:8001/ws");

                socket.addEventListener("open", (event) => {
                    console.log("WebSocket connection opened: ", ws_address);
                    ws_socket.classList.remove("badge-danger");
                    ws_socket.classList.add("badge-success");
                    ws_socket.textContent = "Connected ..";
                    socket.send("Hello Server!");
                    Livewire.emit('refreshComponent')
                });
                socket.addEventListener("message", (event) => {
                    var data = JSON.parse(event.data);




                    if (data.type === "Dial") {
                        // alert( incomingCall);


                    }
                    else
                    if (data.type === "Answer") {
                        // alert( incomingCall);
                        console.log("Incoming Call Data:", data);


                    }
                    else
                    if (data.type === "StasisStart") {
                        // alert( incomingCall);
                        console.log("Incoming Call Data:", data);

                    }
                    else
                    if (data.type === "NoAnswer") {
                        // alert( incomingCall);
                        console.log("Incoming Call Data:", data);

                    }
                    else
                    if (data.type === "StasisEnd") {
                        //     // alert( incomingCall);
                        console.log("Incoming Call Data:", data.channel.dialplan.app_data);

                        const appData = data.channel.dialplan.app_data;
                        const parts = appData.split(',');


                        // if (parts.length >= 5) {
                        //     const filename = parts[5];
                        //     const agent = parts[2].slice(-4);

                        //     console.error(
                        //         "Error: app_data does not contain enough parts. open modal for agent",
                        //         agent);


                        // } else {
                        //     console.error("Error: app_data does not contain enough parts.");
                        // }

                        console.log("Incoming Call Data:", data);
                    }
                    else
                    {
                        console.log("Incoming Call Data:", data);
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

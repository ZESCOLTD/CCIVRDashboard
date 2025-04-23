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

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <h5 class="card-title d-block">Agent Information </h5>
                            <br>
                            <p><strong>Agent Name:</strong> {{ $agent->name }}</p>
                            <p><strong>Agent ID:</strong> {{ $agent->endpoint }}</p>
                            <strong>Agent number:</strong> {{ $agent->endpoint }}<br>
                            <p><strong>Status:</strong>
                                @switch($agent->status)
                                    @case('LOGGED_IN')
                                        <span class="badge badge-success">LOGGED IN</span>
                                    @break

                                    @case('LOGGED_OUT')
                                        <span class="badge badge-secondary">LOGGED OUT</span>
                                    @break

                                    @case('IDLE')
                                        <span class="badge badge-warning">IDLE</span>
                                    @break

                                    @case('WITHDRAWN')
                                        <span class="badge badge-danger">WITHDRAWN</span>
                                    @break

                                    @case('WRAPPING_UP')
                                        <span class="badge badge-info">WRAPPING UP</span>
                                    @break

                                    @case('IN_CONVERSATION')
                                        <span class="badge badge-primary">IN CONVERSATION</span>
                                    @break

                                    @default
                                        <span class="badge badge-light">UNKNOWN</span>
                                @endswitch
                            </p>
                        </div>




                        <div class="col-md-4">
                            <h5 class="card-title">Session Info</h5> <br>
                            <label class="text-info">Recorder Websocket:</label>
                            <input type="text" id="ws_endpoint" value='{{ $ws_server }}' hidden>
                            <span id="ws-info" class="badge badge-default">Connecting...</span>
                            <br>


                            <!-- Blade Template -->

                            <!-- Current Session Display -->
                            <p><strong>Current Session:</strong>
                                @if ($currentSession)
                                    <span class="badge badge-info">{{ $currentSession->name }}</span><br>
                                    <strong>Time From:</strong> {{ $currentSession->time_from }}<br>
                                    <strong>Time To:</strong> {{ $currentSession->time_to }}
                                    <button class="btn btn-sm btn-outline-primary ml-1" wire:click="showModal">Change
                                        Session</button>
                                @else
                                    <span class="badge badge-warning">No session selected</span>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            @this.call('showModal');
                                        });
                                    </script>
                                @endif
                            </p>




                        </div>
                        <div class="col-md-4">

                            <h5 class="card-title">Current Call</h5>
                            <p><strong>Caller ID:</strong> +1234567890</p>
                            <p><strong>Call Duration:</strong> 00:03:15</p>
                            @if ($this->agent->state == config('constants.agent_state.LOGGED_IN'))
                                <button wire:click="logout()" class="btn btn-danger btn-block">Logout</button>
                            @else
                                <button wire:click="login()" class="btn btn-success btn-block">Login</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Metrics Overview -->
            <div class="row">
                <div class="col-md-3">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-phone-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Calls</span>
                            <span class="info-box-number">{{ $totalCalls }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Answered Calls</span>
                            <span class="info-box-number">{{ $answeredCalls }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-danger">
                        <span class="info-box-icon"><i class="fas fa-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Missed Calls</span>
                            <span class="info-box-number">{{ $missedCalls }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-warning">
                        <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Average Call Time</span>
                            <span class="info-box-number">{{ $averageCallTime }}</span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Graph Placeholders -->
            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Call Volume (Last 7 Days)</h5>
                            <div style="height: 300px; background-color: #f2f2f2;">
                                <!-- Placeholder for Call Volume Graph -->
                                <p class="text-center text-muted">[Graph Placeholder]</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Agent Performance</h5>
                            <div style="height: 300px; background-color: #f2f2f2;">
                                <!-- Placeholder for Agent Performance Graph -->
                                <p class="text-center text-muted">[Graph Placeholder]</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


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
            </style>

            <!-- Combined Call Control and Incoming Call Information Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h1 style="text-align: center">Agent Knowledge Base (Type In the Topic of Interest)</h1>
                </div>

                <div class="card-body">
                    <!-- Knowledge Base Search Section -->
                    <div class="knowledge-base-search mb-4">
                        <h5 class="mb-3">Knowledge Base Quick Search</h5>

                        <div class="form-group position-relative">
                            <input
                                type="text"
                                class="form-control"
                                wire:model.debounce.300ms="searchQuery"
                                placeholder="Search knowledge base..."
                                autocomplete="off"
                            >

                            @if(!empty($searchResults))
                                <div class="search-suggestions position-absolute w-100 bg-white shadow-lg rounded mt-1 z-index-100">
                                    <ul class="list-group">
                                        @foreach($searchResults as $result)
                                            <li class="list-group-item list-group-item-action"
                                                wire:click="selectTopic({{ $result['id'] }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#knowledgeModal"
                                                style="cursor: pointer;">
                                                <strong>{{ $result['topic'] }}</strong>
                                                <div class="text-muted small text-truncate">
                                                    {{ $result['description'] }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                @if(!empty($searchQuery))
                                    <div class="no-results p-2 text-center text-muted">
                                        <p>No topics found for "<strong>{{ $searchQuery }}</strong>"</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="knowledgeModal" tabindex="-1" role="dialog" aria-labelledby="knowledgeModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <h1 style="color: #f49434 ">@if($selectedTopic)</h1>

                            <div class="modal-header">
                                <h5 class="modal-title" id="knowledgeModalLabel">{{ $selectedTopic->topic }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="$set('selectedTopic', null)"></button>
                            </div>
                            <div class="modal-body">
{{--                                {!! $selectedTopic->content !!}--}}
                                {!! $selectedTopic->description !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Combined Call Control and Incoming Call Information Card -->



            <div class="card mb-4">
                <div class="card-header">
                    <span class="text-bold text-orange">Customer Details </span>

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search by meter number or name..."
                            wire:model.debounce.300ms="meter_number">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="container mt-5">


                        @if ($customer_details && $customer_details->isNotEmpty())
                            @foreach ($customer_details as $customer)
                                <table class="table table-bordered table-striped mt-4">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Field</th>
                                            <th>Value</th>
                                            <th>Field</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Division</td>
                                            <td>{{ $customer->division ?? '--' }}</td>
                                            <td>Service Number</td>
                                            <td>{{ $customer->service_no ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Service Point</td>
                                            <td>{{ $customer->service_point ?? '--' }}</td>
                                            <td>Itinerary Assigned</td>
                                            <td>{{ $customer->itinerary_assigned ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Premise ID</td>
                                            <td>{{ $customer->premise_id ?? '--' }}</td>
                                            <td>Customer Name</td>
                                            <td>{{ $customer->customer_name ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Meter Number</td>
                                            <td>{{ $customer->meter_no ?? '--' }}</td>
                                            <td>Meter Serial Number</td>
                                            <td>{{ $customer->meter_serial_no ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Meter Make</td>
                                            <td>{{ $customer->meter_make ?? '--' }}</td>
                                            <td>Meter Type Code</td>
                                            <td>{{ $customer->meter_type_code ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Meter Status</td>
                                            <td>{{ $customer->meter_status ?? '--' }}</td>
                                            <td>Phase Type</td>
                                            <td>{{ $customer->phase_type ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Voltage Type</td>
                                            <td>{{ $customer->voltage_type ?? '--' }}</td>
                                            <td>Meter Rating</td>
                                            <td>{{ $customer->meter_rating ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Meter Constant</td>
                                            <td>{{ $customer->meter_constant ?? '--' }}</td>
                                            <td>Meter Installation Date</td>
                                            <td>{{ $customer->meter_instal_date ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Town</td>
                                            <td>{{ $customer->town ?? '--' }}</td>
                                            <td>Meter Type</td>
                                            <td>{{ $customer->meter_type ?? '--' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Connection Type</td>
                                            <td>{{ $customer->connection_type ?? '--' }}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        @endif
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
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">WebSocket Data</h5>
                    <pre id="json-data">[WebSocket Data Placeholder]</pre>
                </div>
            </div>




            <!-- Session Selection Modal -->
            <div class="modal fade" id="sessionModal" tabindex="-1" role="dialog"
                aria-labelledby="sessionModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false"
                wire:ignore.self>
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
                                <button type="button" class="btn btn-primary disabled "
                                    wire:click="saveSession">Save
                                    changes ... </button>
                            @else
                                <button type="button" class="btn btn-primary" wire:click="saveSession">Save
                                    changes</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <iframe src="{{ url('phone') }}"width="100%" height="800"></iframe>
            </div>


        </div>
    </div>

</div>

@push('custom-scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



    <script>
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

    <script>
        Livewire.on('closeModal', () => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('knowledgeModal'));
            if (modal) {
                modal.hide();
            }
        });
    </script>
@endpush

<div class="container mt-4">


    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- Personal Information Card -->
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <!-- Profile Picture Section -->
                                <img src="https://via.placeholder.com/150" alt="Profile Picture"
                                    class="rounded-circle img-thumbnail" style="width: 150px; height: 150px;">
                                <h4 class="mt-3 text-muted text-bold">{{ $agent->name }}</h5>
                            </div>
                            <hr>
                            <!-- Flexbox for aligned items -->
                            <div class="d-flex justify-content-start mb-3">
                                <div><i class="fas fa-id-badge"></i> Man No.:</div>
                                <div class="text-muted text-bold">{{ $agent->man_no }}</div>
                            </div>
                            <div class="d-flex justify-content-start mb-3">
                                <div><i class="fas fa-envelope"></i> Email:</div>
                                <div class="text-muted text-bold">{{ $agent->user->email ?? '' }}</div>
                            </div>
                            <div class="d-flex justify-content-start mb-3">
                                <div><i class="fas fa-phone"></i> Phone Number:</div>
                                <div class="text-muted text-bold">{{ $agent->user->mobile_no ?? '' }}</div>
                            </div>
                            <div class="d-flex justify-content-start mb-3">
                                <div><i class="fas fa-briefcase"></i> Job Title:</div>
                                <div class="text-muted text-bold">{{ $agent->user->job_title ?? '' }}</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end">

                                <a href="{{ route('live.agent.dashboard', ['id' => $agent->user->id ?? 0]) }}"
                                    class="btn btn-primary mr-3">View Dashboard</a>

                                <button data-toggle="modal" data-target="#updateModal"
                                    class="btn btn-info mr-3">Edit</button>
                                <button wire:click.prevent="remove()" onclick="deleteCallSession('{{ $agent->id }}')"
                                    class="btn btn-danger">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Agent Details Card -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h5 class="mb-0">Agent Details</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Flexbox for aligned items -->
                                    <div class="d-flex justify-content-start mb-3">
                                        <div><i class="fas fa-user-secret"></i> Agent Number:</div>
                                        <div class="text-muted text-bold">{{ $agent->endpoint }}</div>
                                    </div>
                                    <div class="d-flex justify-content-start mb-3">
                                        <div><i class="fas fa-layer-group"></i> Set Number:</div>
                                        <div class="text-muted text-bold">{{ $agent->set_number }}</div>
                                    </div>
                                    <div class="d-flex justify-content-start mb-3">
                                        <div><i class="fas fa-building"></i> Department:</div>
                                        <div class="text-muted text-bold">{{ $agent->user->functional_section ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information Card -->
                        <div class="col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h5 class="mb-0">Status Information</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Flexbox for aligned items -->
                                    <div class="d-flex justify-content-start mb-3">
                                        <div><i class="fas fa-map-marker-alt"></i> State:</div>
                                        <div>
                                            <!-- Dynamic badge based on agent's state -->
                                            <span
                                                class="badge
                                                {{ $agent->state == 'LOGGED_IN' ? 'badge-success' : '' }}
                                                {{ $agent->state == 'LOGGED_OUT' ? 'badge-secondary' : '' }}
                                                {{ $agent->state == 'ON_A_CALL' ? 'badge-warning' : '' }}">
                                                {{ $agent->state }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start mb-3">
                                        <div><i class="fas fa-info-circle"></i> Status:</div>
                                        <div>
                                            <span
                                                class="badge badge-{{ $agent->status == 'active' ? 'success' : 'danger' }}">
                                                {{ $agent->status == 'active' ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Agent recordings Information Card -->
                        <div class="col-md-12">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h5 class="mb-0">Recordings Information</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="Search by phone number or agent..."
                                            wire:model.debounce.300ms="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col d-flex align-items-end">
                                            <div class="mr-2">
                                                <label for="from">From: </label>
                                                <input type="datetime-local" class="form-control" id="from"
                                                    placeholder="Enter Date" wire:model.defer="from">
                                                @error('context')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mr-2">
                                                <label for="to">To: </label>
                                                <input type="datetime-local" class="form-control" id="to"
                                                    placeholder="Enter Date" wire:model.defer="to">
                                                @error('context')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div>
                                                <button type="submit" wire:click="filterRecordings"
                                                    class="btn btn-outline-success">
                                                    <div wire:loading>
                                                        <span class="spinner-border spinner-border-sm mr-2"
                                                            role="status" aria-hidden="true"></span>
                                                    </div>
                                                    <span>Search</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <span>{{ $rec_title }}: {{ $totalRecords }}</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th>Recording ID</th>
                                                    {{-- <th>Phone Number</th> --}}
                                                    <th>Agent</th>
                                                    <th>Call Date</th>
                                                    {{-- <th>Source</th> --}}
                                                    {{-- <th>Destination</th> --}}
                                                    <th>Caller ID</th>

                                                    <th>Answered Date</th>
                                                    <th>Hang Up</th>
                                                    <th>Duration</th>
                                                    <th>Transaction Code</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recordings as $recording)
                                                    <tr>
                                                        <td>{{ $recording->id }}</td>
                                                        <td>
                                                            <a href="{{ $recording->agent_number }}">
                                                                {{ str_replace('SIP/7000/', '', $recording->agent_number) }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $recording->created_at ?? '--' }}</td>
                                                        {{-- <td>{{ $recording->src ?? '--' }}</td> --}}
                                                        {{-- <td>{{ $recording->dst ?? '--' }}</td> --}}
                                                        <td>{{ $recording->clid ?? '--' }}</td>
                                                        {{-- <td>{{ $recording->calldate ?? '--' }}</td> --}}
                                                        <td>{{ $recording->answerdate ?? '--' }}</td>
                                                        <td>{{ $recording->hangupdate ?? '--' }}</td>
                                                        <td>{{ $recording->call_duration ?? '-' }}</td>

                                                        <td> {{ $recording->tCode->name ?? ($recording->transaction_code ?? '--') }}
                                                        </td>
                                                        <td class="p-1 m-1">

                                                            <button data-toggle="modal"
                                                                data-target="#updateTransactionCodeModal"
                                                                wire:click="getTranasactionCodes({{ $recording->id }})"
                                                                class="btn btn-primary btn-sm p-1 m-1">Add
                                                                code</button>

                                                            <a class="btn btn-sm btn-outline-success p-1 m-1"
                                                                href="{{ route('live.recordings.show', ['id' => $recording->id]) }}">Listen</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>{{ $recordings->links() }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    @include('livewire.agent.edit')
    @include('livewire.agent.transaction-code')


    <script>
        function deleteCallSession(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteCallSession', id);
        }

        document.addEventListener('livewire:load', function() {
            @this.on('closeModal', () => {
                $('#updateModal').modal('hide');
                $('#updateTransactionCodeModal').modal('hide');
            });
        });
    </script>
</div>

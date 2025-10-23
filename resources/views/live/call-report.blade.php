<div>
    <h2 class="h2 text-dark mb-4">Stasis Call Detail Report Dashboard</h2>

    <!-- Filter Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary">Dynamic Data Filters</h5>

            <!-- Time Range Filter (Existing) -->
            <div class="row border-bottom pb-3 mb-3">
                <div class="col-md-5 form-group">
                    <label for="startDate">Start Time</label>
                    <input type="datetime-local" id="startDate" wire:model.defer="startDate" class="form-control">
                </div>
                <div class="col-md-5 form-group">
                    <label for="endDate">End Time</label>
                    <input type="datetime-local" id="endDate" wire:model.defer="endDate" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end form-group">
                    <button wire:click="applyFilter" class="btn btn-primary btn-block">Apply Filter</button>
                </div>
            </div>

            <!-- Column Filters (Text and Status) -->
            <div class="row mb-3">
                <!-- Caller Number Filter -->
                <div class="col-md-3 form-group">
                    <label for="filterCallerNumber">Caller Number</label>
                    <input type="text" id="filterCallerNumber" wire:model.defer="filterCallerNumber" class="form-control form-control-sm" placeholder="Search number...">
                </div>

                <!-- Agent Extension Filter -->
                <div class="col-md-3 form-group">
                    <label for="filterAgentExtension">Agent Extension</label>
                    <input type="text" id="filterAgentExtension" wire:model.defer="filterAgentExtension" class="form-control form-control-sm" placeholder="Search extension...">
                </div>

                <!-- Status Filter (Dropdown) -->
                <div class="col-md-3 form-group">
                    <label for="filterStatus">Call Status</label>
                    <select id="filterStatus" wire:model.defer="filterStatus" class="form-control form-control-sm">
                        <option value="">All Statuses</option>
                        <option value="answered">Answered</option>
                        <option value="abandoned">Abandoned</option>
                        <option value="short_miss">Short Missed</option>
                        {{-- Assuming 'unknown' or active calls are those not marked as the others --}}
                        <option value="unknown">Unknown / Active</option>
                    </select>
                </div>

                <div class="col-md-3"></div>
            </div>

            <!-- Duration Filters (Ring and Talk Time in Seconds) -->
            <h6 class="mt-3 text-muted border-top pt-3">Filter by Call Durations (in Seconds)</h6>
            <div class="row">
                <!-- Min/Max Ring Duration Filters -->
                <div class="col-md-3 form-group">
                    <label for="filterMinRingDuration">Min Ring Duration</label>
                    <input type="number" id="filterMinRingDuration" wire:model.defer="filterMinRingDuration" class="form-control form-control-sm" placeholder="Min Ring (s)">
                </div>
                <div class="col-md-3 form-group">
                    <label for="filterMaxRingDuration">Max Ring Duration</label>
                    <input type="number" id="filterMaxRingDuration" wire:model.defer="filterMaxRingDuration" class="form-control form-control-sm" placeholder="Max Ring (s)">
                </div>

                <!-- Min/Max Talk Time Filters -->
                <div class="col-md-3 form-group">
                    <label for="filterMinTalkTime">Min Talk Time</label>
                    <input type="number" id="filterMinTalkTime" wire:model.defer="filterMinTalkTime" class="form-control form-control-sm" placeholder="Min Talk (s)">
                </div>
                <div class="col-md-3 form-group">
                    <label for="filterMaxTalkTime">Max Talk Time</label>
                    <input type="number" id="filterMaxTalkTime" wire:model.defer="filterMaxTalkTime" class="form-control form-control-sm" placeholder="Max Talk (s)">
                </div>
            </div>

        </div>
    </div>


    <!-- Metrics Summary Cards -->
    <div class="row mb-4">
        @if ($metrics)
            <div class="col-md-3">
                <div class="card border-primary mb-3">
                    <div class="card-body text-center">
                        <p class="text-muted mb-0">Total Attempts</p>
                        <h3 class="card-title text-primary">{{ $metrics->total_attempts ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-success mb-3">
                    <div class="card-body text-center">
                        <p class="text-muted mb-0">Answered Calls</p>
                        <h3 class="card-title text-success">{{ $metrics->answered_calls ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-danger mb-3">
                    <div class="card-body text-center">
                        <p class="text-muted mb-0">Abandoned Calls</p>
                        <h3 class="card-title text-danger">{{ $metrics->abandoned_calls ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-info mb-3">
                    <div class="card-body text-center">
                        <p class="text-muted mb-0">Service Level (Answered/Handled)</p>
                        {{-- Accesses getServiceLevelProperty() in the Livewire component --}}
                        <h3 class="card-title text-info">{{ $this->serviceLevel }}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Additional Metrics Summary Bar -->
    <div class="row text-center bg-light p-3 rounded mb-4 shadow-sm">
        <div class="col-md-4">
            <p class="h5 mb-0 text-dark">{{ $metrics->avg_time_to_answer ?? 0 }}s</p>
            <small class="text-muted">Avg. Time to Answer</small>
        </div>
        <div class="col-md-4">
            <p class="h5 mb-0 text-dark">{{ $metrics->avg_talk_time ?? 0 }}s</p>
            <small class="text-muted">Avg. Talk Time</small>
        </div>
        <div class="col-md-4">
            <p class="h5 mb-0 text-dark">{{ $metrics->short_missed_calls ?? 0 }}</p>
            <small class="text-muted">Short Missed Calls</small>
        </div>
    </div>


    <!-- Detailed Call Records Table -->
    <h3 class="h4 text-dark mb-3">Recent Call Attempts ({{ $callRecords->total() }})</h3>
    <div class="table-responsive">
        <table class="table table-hover table-sm bg-white shadow-sm">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Start Time</th>
                    <th scope="col">Caller Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">Agent/Extension</th>
                    <th scope="col">TT Answer (s)</th>
                    <th scope="col">Talk Time (s)</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($callRecords as $cdr)
                    <tr>
                        <td>{{ $cdr->start_time->format('M d H:i:s') }}</td>
                        <td>{{ $cdr->caller_number }}</td>
                        <td>
                            @if($cdr->is_answered)
                                <span class="badge badge-success">Answered</span>
                            @elseif($cdr->is_abandoned)
                                <span class="badge badge-danger">Abandoned</span>
                            @elseif($cdr->is_short_miss)
                                <span class="badge badge-warning">Short Miss</span>
                            @else
                                <span class="badge badge-secondary">Active/Unknown</span>
                            @endif
                        </td>
                        <td>
                            {{ $cdr->agent_extension ? $cdr->agent_extension . ' (' . $cdr->agent_name . ')' : 'N/A' }}
                        </td>
                        <td>{{ $cdr->time_to_answer_seconds ?? '-' }}</td>
                        <td>{{ $cdr->talk_time_seconds ?? '-' }}</td>
                        <td>
                            <a href="{{ route('stasis-cdr.show', $cdr->id) }}" class="btn btn-sm btn-outline-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No call records found for the selected period and filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="mt-3">
            {{ $callRecords->links() }}
        </div>
    </div>
</div>

<div>
    <h2 class="h2 text-dark mb-4">Stasis Call Detail Report Dashboard</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filter by Time Range</h5>
            <div class="row">
                <div class="col-md-5 form-group">
                    <label for="startDate">Start Time</label>
                    <input type="datetime-local" id="startDate" wire:model.defer="startDate" class="form-control">
                </div>
                <div class="col-md-5 form-group">
                    <label for="endDate">End Time</label>
                    <input type="datetime-local" id="endDate" wire:model.defer="endDate" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button wire:click="applyFilter" class="btn btn-primary btn-block">Apply Filter</button>
                </div>
            </div>
        </div>
    </div>

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
                        <h3 class="card-title text-info">{{ $this->serviceLevel }}</h3>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row text-center bg-light p-3 rounded mb-4">
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


    <h3 class="h4 text-dark mb-3">Recent Call Attempts ({{ $callRecords->count() }})</h3>
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
                        <td colspan="7" class="text-center text-muted">No call records found for the selected period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $callRecords->links() }}
        </div>
    </div>
</div>
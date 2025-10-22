
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h1 class="h3 card-title text-dark">Call Detail Record (CDR) Details</h1>
                <span class="text-muted font-weight-bold">ID: {{ $cdr->id }}</span>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">
                &larr; Back to Report
            </a>

            @php
                $status_class = 'alert-secondary';
                $status_text = 'IN PROGRESS / UNKNOWN';
                if ($cdr->is_answered) {
                    $status_class = 'alert-success';
                    $status_text = 'ANSWERED';
                } elseif ($cdr->is_abandoned) {
                    $status_class = 'alert-danger';
                    $status_text = 'ABANDONED';
                } elseif ($cdr->is_short_miss) {
                    $status_class = 'alert-warning';
                    $status_text = 'SHORT MISS / RING';
                }
            @endphp

            <div class="alert {{ $status_class }} mb-4" role="alert">
                <h4 class="alert-heading">{{ $status_text }}</h4>
                <p class="mb-0">
                    @if($cdr->agent_extension)
                        Agent: <span class="font-weight-bold">{{ $cdr->agent_name }}</span> (Extension: {{ $cdr->agent_extension }})
                    @else
                        Agent: N/A
                    @endif
                </p>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-1 text-primary">Core Identifiers</h5>
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <p class="text-muted mb-0">Caller Number</p>
                    <p class="lead font-weight-bold">{{ $cdr->caller_number }}</p>
                </div>
                <div class="col-md-5 mb-3">
                    <p class="text-muted mb-0">Caller Channel ID</p>
                    <p class="text-monospace small">{{ $cdr->caller_channel_id }}</p>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="text-muted mb-0">Callee Channel ID (Answer Leg)</p>
                    <p class="text-monospace small">{{ $cdr->callee_channel_id ?? 'N/A' }}</p>
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-1 text-primary">Metrics & Timestamps</h5>

            <div class="row text-center mb-4">
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <p class="text-muted mb-0">Ring Duration</p>
                        <p class="h4 text-info">{{ $cdr->ring_duration_seconds ?? 0 }}s</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <p class="text-muted mb-0">Time To Answer</p>
                        <p class="h4 text-info">{{ $cdr->time_to_answer_seconds ?? 0 }}s</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded">
                        <p class="text-muted mb-0">Talk Time</p>
                        <p class="h4 text-info">{{ $cdr->talk_time_seconds ?? 0 }}s</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4 small">
                <div class="col-md-4">
                    <p class="text-muted mb-0">Start Time</p>
                    <p class="font-weight-bold">{{ $cdr->start_time->toDateTimeString() }}</p>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-0">Answer Time</p>
                    <p class="font-weight-bold">{{ $cdr->answer_time ? $cdr->answer_time->toDateTimeString() : 'N/A' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="text-muted mb-0">End Time</p>
                    <p class="font-weight-bold">{{ $cdr->end_time ? $cdr->end_time->toDateTimeString() : 'N/A' }}</p>
                </div>
            </div>

            <h5 class="mt-4 mb-3 border-bottom pb-1 text-primary">Raw Event Auditing</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="text-muted mb-0">Stasis Start Event ID</p>
                    <a href="/stasis-start/{{ $cdr->stasis_start_event_id }}" class="text-info font-weight-bold">
                        {{ $cdr->stasis_start_event_id }}
                    </a>
                    <small class="d-block text-muted">Original call initiation event.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <p class="text-muted mb-0">Stasis End Event ID</p>
                    @if($cdr->stasis_end_event_id)
                        <a href="/stasis-end/{{ $cdr->stasis_end_event_id }}" class="text-info font-weight-bold">
                            {{ $cdr->stasis_end_event_id }}
                        </a>
                        <small class="d-block text-muted">Call termination event.</small>
                    @else
                        <span class="text-secondary font-weight-bold">Call Still Active</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

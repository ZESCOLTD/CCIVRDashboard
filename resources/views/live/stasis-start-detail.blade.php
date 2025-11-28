<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Raw Stasis Start Event (ID: {{ $event->id }})</h3>
        </div>
        <div class="card-body">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back to CDR Detail</a>

            {{-- Summary Block --}}
            <div class="alert alert-info py-2" role="alert">
                <h6 class="mb-0">
                    <i class="fa fa-info-circle mr-2"></i> Event Type: <span class="font-weight-bold">{{ $event->event_type ?? 'StasisStart' }}</span>
                    @if ($event->bridge_id)
                        | Bridge ID: <span class="font-weight-bold text-monospace">{{ $event->bridge_id }}</span>
                    @endif
                </h6>
            </div>

            <h5 class="mt-4 border-bottom pb-1 text-primary">Core Channel & Time Data</h5>
            <dl class="row small">
                <dt class="col-sm-3">Timestamp</dt>
                <dd class="col-sm-9">{{ $event->created_at->toDateTimeString() }}</dd>

                <dt class="col-sm-3">Channel ID</dt>
                <dd class="col-sm-9 text-monospace text-break">{{ $event->channel_id }}</dd>

                <dt class="col-sm-3">Caller Number</dt>
                <dd class="col-sm-9 font-weight-bold">{{ $event->caller_number }}</dd>

                <dt class="col-sm-3">Connected Line</dt>
                <dd class="col-sm-9">{{ $event->connected_line_name ?? 'N/A' }} (ID: {{ $event->connected_line_id ?? 'N/A' }})</dd>
            </dl>

            <h5 class="mt-4 border-bottom pb-1 text-primary">Application and Context</h5>
            <dl class="row small">
                <dt class="col-sm-3">Application</dt>
                <dd class="col-sm-9 font-weight-bold">{{ $event->application_name ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Context</dt>
                <dd class="col-sm-9">{{ $event->context ?? 'N/A' }}</dd>

                <dt class="col-sm-3">Dialed Extension</dt>
                <dd class="col-sm-9 font-weight-bold">{{ $event->dialed_extension ?? 'Unknown' }}</dd>

                <dt class="col-sm-3">Language</dt>
                <dd class="col-sm-9">{{ $event->language ?? 'en' }}</dd>
            </dl>

            <h5 class="mt-4 border-bottom pb-1 text-primary">Raw JSON Payload</h5>
            <div class="row">
                <div class="col-12">
                    <pre class="bg-dark text-white p-3 border rounded overflow-auto" style="max-height: 500px;"><code>
                        @php
                            // Safely decode the raw data for pretty printing
                            $rawData = $event->raw_data;
                            if (is_string($rawData)) {
                                $rawData = json_decode($rawData, true);
                            }
                        @endphp
                        @if (is_array($rawData) || is_object($rawData))
                            {{ json_encode($rawData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                        @else
                            {{ $event->raw_data ?? 'No raw data available.' }}
                        @endif
                    </code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
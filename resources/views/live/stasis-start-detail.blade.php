
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Raw Stasis Start Event (ID: {{ $event->id }})</h3>
        </div>
        <div class="card-body">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back to CDR Detail</a>

            <h5 class="mt-3">Core Event Data</h5>
            <dl class="row">
                <dt class="col-sm-3">Timestamp</dt>
                <dd class="col-sm-9">{{ $event->created_at->toDateTimeString() }}</dd>

                <dt class="col-sm-3">Channel ID</dt>
                <dd class="col-sm-9 text-monospace">{{ $event->channel_id }}</dd>

                <dt class="col-sm-3">Caller Number</dt>
                <dd class="col-sm-9">{{ $event->caller_number }}</dd>
            </dl>

            <h5 class="mt-4">Raw JSON Data</h5>
            <pre class="bg-light p-3 border rounded"><code>
                {{-- Assuming the raw data is in a column named 'raw_data' --}}
                @if (is_array($event->raw_data) || is_object($event->raw_data))
                    {{ json_encode($event->raw_data, JSON_PRETTY_PRINT) }}
                @else
                    {{ $event->raw_data ?? 'No raw data available.' }}
                @endif
            </code></pre>
        </div>
    </div>
</div>

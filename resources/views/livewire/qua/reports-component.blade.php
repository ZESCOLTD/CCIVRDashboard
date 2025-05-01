<div class="container py-5">
    <h1 class="mb-4">Asterisk Call Recordings</h1>

    <form wire:submit.prevent="search" class="row g-3 bg-white p-4 rounded shadow-sm">
        {{-- Date Filters --}}
        <div class="col-md-6">
            <label for="fromDate" class="form-label">From</label>
            <input type="datetime-local" class="form-control" id="fromDate" wire:model.defer="filters.from">
        </div>
        <div class="col-md-6">
            <label for="toDate" class="form-label">To</label>
            <input type="datetime-local" class="form-control" id="toDate" wire:model.defer="filters.to">
        </div>

        {{-- Channel Filters --}}
        <div class="col-md-4">
            <label for="src" class="form-label">Source (src)</label>
            <input type="text" class="form-control" id="src" wire:model.defer="filters.src">
        </div>
        <div class="col-md-4">
            <label for="dst" class="form-label">Destination (dst)</label>
            <input type="text" class="form-control" id="dst" wire:model.defer="filters.dst">
        </div>
        <div class="col-md-4">
            <label for="clid" class="form-label">Caller ID</label>
            <input type="text" class="form-control" id="clid" wire:model.defer="filters.clid">
        </div>

        {{-- Duration Filters --}}
        <div class="col-md-3">
            <label for="durMin" class="form-label">Duration Min (s)</label>
            <input type="number" class="form-control" id="durMin" wire:model.defer="filters.duration_min">
        </div>
        <div class="col-md-3">
            <label for="durMax" class="form-label">Duration Max (s)</label>
            <input type="number" class="form-control" id="durMax" wire:model.defer="filters.duration_max">
        </div>

        {{-- Transaction Code --}}
        <div class="col-md-6">
            <label for="transactionCode" class="form-label">Transaction Code</label>
            <input type="text" class="form-control" id="transactionCode" wire:model.defer="filters.transaction_code">
        </div>

        {{-- Group & Export Options --}}
        <div class="col-md-4">
            <label for="groupBy" class="form-label">Group By</label>
            <select class="form-select" id="groupBy" wire:model.defer="filters.group_by">
                <option value="">-- None --</option>
                <option value="day">Day</option>
                <option value="src">Source</option>
                <option value="dst">Destination</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Export</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model.defer="filters.export_csv" id="csvExport">
                <label class="form-check-label" for="csvExport">CSV</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" wire:model.defer="filters.export_graph" id="graphExport">
                <label class="form-check-label" for="graphExport">Graph</label>
            </div>
        </div>

        <div class="col-md-4">
            <label for="limit" class="form-label">Result Limit</label>
            <input type="number" class="form-control" id="limit" wire:model.defer="filters.limit">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    {{-- Results Table --}}
    <div class="mt-5">
        @if(empty($records))
            <p class="text-muted">No recordings found.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Destination</th>
                            <th>Caller ID</th>
                            <th>Duration</th>
                            <th>Billsec</th>
                            <th>Disposition</th>
                            <th>Transaction Code</th>
                            <th>Recording</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td>{{ $record->calldate }}</td>
                                <td>{{ $record->src }}</td>
                                <td>{{ $record->dst }}</td>
                                <td>{{ $record->clid }}</td>
                                <td>{{ $record->call_duration }}</td>
                                <td>{{ $record->billsec }}</td>
                                <td>{{ $record->disposition }}</td>
                                <td>{{ optional($record->tCode)->label ?? 'N/A' }}</td>
                                <td>
                                    @if($record->file_path)
                                        <a href="{{ asset($record->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Play</a>
                                    @else
                                        <span class="text-muted">No file</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

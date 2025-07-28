@php
    function getNetworkBadgeColor($network) {
        switch (strtolower($network)) {
            case 'airtel': return '#F70000';
            case 'mtn': return '#FFCB05';
            case 'zamtel': return '#20AC49';
            case 'whatsapp': return '#34B7F1';
            default: return '#6c757d'; // bootstrap secondary color fallback
        }
    }
@endphp

<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Daily Stats Summary (Last 24 Hours)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>Network/Channel</th>
                    <th class="text-right">Sessions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dailyStats as $item)
                @php
                    $color = getNetworkBadgeColor($item->network);
                @endphp
                <tr>
                    <td>
                        <span class="badge" style="background-color: {{ $color }}; color: #fff;">
                            {{ ucfirst($item->network) }}
                        </span>
                    </td>
                    <td class="text-right" style="color: {{ $color }}">{{ $item->sessions }}</td>
                </tr>
            @endforeach
            <tr class="text-bold">
                <td>Total</td>
                <td class="text-bold text-right">{{ $dailyStats->sum('sessions') }}</td>
            </tr>
            </tbody>
        </table>

        @php
    $top = $dailyStats->sortByDesc('sessions')->first();
    $least = $dailyStats->sortBy('sessions')->first();
    $total = $dailyStats->sum('sessions');
@endphp

@php
    $top = $dailyStats->sortByDesc('sessions')->first();
    $least = $dailyStats->sortBy('sessions')->first();
    $total = $dailyStats->sum('sessions');

    $topColor = getNetworkBadgeColor($top->network);
    $leastColor = getNetworkBadgeColor($least->network);
@endphp

<div class="mt-3 p-3 bg-light rounded">
    <h4>Analysis</h5>
    <h4>
        In the last 24 hours, a total of <strong>{{ number_format($total) }}</strong> sessions were recorded.
        The highest activity was on
        <strong style="color: {{ $topColor }}">{{ ucfirst($top->network) }}</strong>
        with <strong style="color: {{ $topColor }}">{{ number_format($top->sessions) }}</strong> sessions,
        while <strong style="color: {{ $leastColor }}">{{ ucfirst($least->network) }}</strong>
        had the lowest at <strong style="color: {{ $leastColor }}">{{ number_format($least->sessions) }}</strong> sessions.
    </h4>
</div>



    </div>
</div>

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


    $now1 = now();
    $dayCurrent = $now1->copy()->subDay()->format('l');     // Last 24 = yesterday
    $dayPrevious = $now1->copy()->subDays(2)->format('l');  // Previous 24 = day before yesterday

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
                    <th class="text-right">{{ $dayPrevious }} (Previous 24)</th>
                    <th class="text-right">{{ $dayCurrent }} (Last 24)</th>
                    <th class="text-right">Change</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dailyStats as $item)
                @php
                    $color = getNetworkBadgeColor($item->network);
                    $changeColor = $item->change >= 0 ? 'green' : 'red';
                    $arrow = $item->change >= 0 ? '↑' : '↓';
                @endphp
                <tr>
                    <td>
                        <span class="badge" style="background-color: {{ $color }}; color: #fff;">
                            {{ ucfirst($item->network) }}
                        </span>
                    </td>
                    <td class="text-right">{{ $item->sessions }}</td>
                    <td class="text-right" style="color: {{ $color }}">{{ $item->previous }}</td>
                    <td class="text-right" style="color: {{ $changeColor }}">
                        {{ $arrow }} {{ number_format(abs($item->change), 1) }}%
                    </td>
                </tr>
            @endforeach

            <tr class="text-bold">
                <td>Total</td>
                <td class="text-bold text-right">{{ $dailyStats->sum('previous') }}</td>
                <td class="text-bold text-right">{{ $dailyStats->sum('sessions') }}</td>
                <td class="text-bold text-right">
                    @php
                        $totalCurrent = $dailyStats->sum('previous');
                        $totalSessions = $dailyStats->sum('sessions');
                        $totalChange = $totalSessions > 0
                            ? (($totalCurrent - $totalSessions) / $totalSessions) * 100
                            : ($totalCurrent > 0 ? 100 : 0);
                        $totalColor = $totalChange >= 0 ? 'green' : 'red';
                        $totalArrow = $totalChange >= 0 ? '↑' : '↓';
                    @endphp
                    <span style="color: {{ $totalColor }}">
                        {{ $totalArrow }} {{ number_format(abs($totalChange), 1) }}%
                    </span>
                </td>
            </tr>
            </tbody>

        </table>

        @php
    $top = $dailyStats->sortByDesc('previous')->first();
    $least = $dailyStats->sortBy('previous')->first();
    $total = $dailyStats->sum('previous');
@endphp

@php
    $top = $dailyStats->sortByDesc('previous')->first();
    $least = $dailyStats->sortBy('previous')->first();
    $total = $dailyStats->sum('previous');

    $topColor = getNetworkBadgeColor($top->network);
    $leastColor = getNetworkBadgeColor($least->network);
@endphp

<div class="mt-3 p-3 bg-light rounded">
    <h4>Analysis</h5>
    <h4>
        In the last 24 hours, a total of <strong>{{ number_format($total) }}</strong> sessions were recorded.
        The highest activity was on
        <strong style="color: {{ $topColor }}">{{ ucfirst($top->network) }}</strong>
        with <strong style="color: {{ $topColor }}">{{ number_format($top->previous) }}</strong> sessions,
        while <strong style="color: {{ $leastColor }}">{{ ucfirst($least->network) }}</strong>
        had the lowest at <strong style="color: {{ $leastColor }}">{{ number_format($least->previous) }}</strong> sessions.
    </h4>
</div>



    </div>
</div>

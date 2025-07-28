@php
    $totals = [];
    $peaks = [];

    foreach ($dataset as $networkData) {
        $name = $networkData['name'];
        $data = $networkData['data'];
        $total = array_sum($data);
        $max = max($data);
        $hour = $hours[array_search($max, $data)];
        $totals[$name] = $total;
        $peaks[$name] = ['hour' => $hour, 'count' => $max];
    }

    arsort($totals);
    $topNetwork = array_key_first($totals);
    $topTotal = $totals[$topNetwork];
    $leastNetwork = array_key_last($totals);
    $leastTotal = $totals[$leastNetwork];

    // Get colors from dataset
    function getColor($dataset, $name) {
        foreach ($dataset as $item) {
            if ($item['name'] === $name) {
                return $item['color'];
            }
        }
        return '#6c757d';
    }

    $topColor = getColor($dataset, $topNetwork);
    $leastColor = getColor($dataset, $leastNetwork);
@endphp

<div class="">

    <h4>
        The network with the highest total sessions over the last 24 hours was
        <strong style="color: {{ $topColor }}">{{ $topNetwork }}</strong>
        with <strong style="color: {{ $topColor }}">{{ number_format($topTotal) }}</strong> sessions.
        Its peak hour was <strong>{{ $peaks[$topNetwork]['hour'] }}:00</strong> with
        <strong>{{ $peaks[$topNetwork]['count'] }}</strong> sessions.

        In contrast, <strong style="color: {{ $leastColor }}">{{ $leastNetwork }}</strong> recorded the lowest total with
        <strong style="color: {{ $leastColor }}">{{ number_format($leastTotal) }}</strong> sessions.
    </h4>
</div>

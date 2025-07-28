<div class="card">
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Network Sessions</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class="text-lg">Total</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
                <span class="text-bold"> {{$total}}</span>
            </p>
        </div>

        <div class="position-relative mb-4">
            <div id="network-highchart" style="height: 300px;"></div>
        </div>
    </div>
</div>

@push('js')

{{-- <div id="network-pie-chart"></div> --}}

<script>
    // document.addEventListener('livewire:load', function () {
        document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('network-highchart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Sessions per Network'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: ''
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    }
                }
            },
            series: [{
                name: 'Sessions',
                colorByPoint: true,
                data: @json($data)
            }]
        });
    });
</script>


@endpush

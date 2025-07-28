<div class="card" wire:ignore>
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Hourly Sessions</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">

                    @livewire('dashboard.hourly-network-analysis', ['dataset' => $dataset, 'hours' => $hours])

        </div>


        <div class="row">


            <div class="col-md-12">
                <div class="position-relative mb-4">
                    <div id="visitors-highchart" style="height: 300px;"></div>
                </div>


            </div>

        </div>


    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const chart = Highcharts.chart('visitors-highchart', {
            chart: {
                type: 'line',
                height: 300
            },
            title: {
                text: null
            },
            credits: {
        enabled: false // 🚫 removes the watermark
    },
            xAxis: {
                categories: @json($hours),
                labels: {
                    style: {
                        color: '#495057',
                        fontWeight: 'bold'
                    }
                }
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    style: {
                        color: '#495057',
                        fontWeight: 'bold'
                    }
                },
                gridLineColor: 'rgba(0,0,0,0.2)'
            },
            legend: {
                enabled: false
            },
            tooltip: {
                shared: true,
                crosshairs: true
            },
            series: @json($dataset)
        });

        // Livewire.on('refresh', (hours, sessions) => {
        //     chart.xAxis[0].setCategories(hours);

        //     // Update series data
        //     chart.series.forEach((s, idx) => {
        //         if (sessions[idx]) {
        //             s.setData(sessions[idx].data);
        //         }
        //     });
        // });
    });
</script>
@endpush

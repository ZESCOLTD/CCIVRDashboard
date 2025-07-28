<div class="card" wire:ignore>
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Minutely Sessions</h3>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class="text-lg">Total</span>
            </p>
        </div>

        <div class="position-relative mb-4">
            <div id="minutes-highchart" style="height: 300px;"></div>
        </div>
    </div>
</div>

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const minutesChart = Highcharts.chart('minutes-highchart', {
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
                categories: @json($minutes),
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

        // Livewire.on('refresh_minutes', (minutes, sessions) => {
        //     console.log(minutes);
        //     console.log(sessions);

        //     minutesChart.xAxis[0].setCategories(minutes);

        //     minutesChart.series.forEach((series, i) => {
        //         if (sessions[i]) {
        //             series.setData(sessions[i].data);
        //         }
        //     });
        // });
    });
</script>
@endpush

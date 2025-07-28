<div class="container-fluid">
    <div class="row">

        <div class="col-lg-12">
            <livewire:dashboard.minute-network-chart/>
        </div>

        <div class="col-lg-6">
            <livewire:dashboard.hourly-network-chart/>
            <div class="col-lg-6">
                <livewire:dashboard.daily-stats-summary/>
            </div>
        </div>

        <div class="col-lg-3">
            <livewire:dashboard.top-menu-selected-chart/>
        </div>

        <div class="col-lg-3">
            <livewire:dashboard.network-pie-chart/>
        </div>
    </div>
</div>

<!-- Replace canvas with div for Highcharts rendering -->
<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Sales Chart</h3>
    </div>
    <div class="card-body">
        <div id="sales-highchart" style="height: 300px;"></div>
    </div>
</div>

@push('js')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('sales-highchart', {
            chart: {
                type: 'column',
                height: 300
            },
            title: {
                text: null
            },
            xAxis: {
                categories: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                crosshair: true,
                labels: {
                    style: {
                        color: '#495057',
                        fontWeight: 'bold'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return '$' + (this.value >= 1000 ? (this.value / 1000) + 'k' : this.value);
                    },
                    style: {
                        color: '#495057',
                        fontWeight: 'bold'
                    }
                },
                gridLineColor: 'rgba(0, 0, 0, .2)'
            },
            tooltip: {
                shared: true,
                valuePrefix: '$',
                valueSuffix: '',
                formatter: function () {
                    return `<b>${this.x}</b><br/>` +
                        this.points.map(p => `<span style="color:${p.color}">\u25CF</span> ${p.series.name}: <b>$${p.y}</b>`).join('<br/>');
                }
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Current',
                data: [1000, 2000, 3000, 2500, 2700, 2500, 3000],
                color: '#007bff'
            }, {
                name: 'Previous',
                data: [700, 1700, 2700, 2000, 1800, 1500, 2000],
                color: '#ced4da'
            }]
        });
    });
</script>
@endpush

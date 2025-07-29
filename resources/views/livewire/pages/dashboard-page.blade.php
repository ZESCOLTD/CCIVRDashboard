<div class="container-fluid p-2">

    <div class="row g-2">

        <!-- Left Column -->
        <div class="col-lg-4 col-sm-12">
            <div class="card card-body ">
            <h2 class="mb-1 text-uppercase">Usage in the Last 24hrs</h6>

            <!-- Daily Stats Summary -->
            <div class="mb-2 text-bold">
                <livewire:dashboard.daily-stats-summary />
            </div>

              <div class="mb-2 text-bold">

              </div>

        </div>
    </div>

        <!-- Right Column -->
        <div class="col-lg-8 col-sm-12">
            <div class="row g-2">
                <div class="col-md-4">
                    <div class="small">
                        <livewire:dashboard.network-pie-chart />
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="small">
                        <livewire:dashboard.minute-network-chart />
                    </div>
                </div>
            </div>

             <!-- Full Width Chart -->
    <div class="row mt-2">
        <div class="col-sm-12  col-lg-12 ">
            <div class="small">
                <livewire:dashboard.hourly-network-chart />
            </div>
        </div>
    </div>
        </div>
    </div>


</div>



@push('custom-scripts')


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

<div class="card"   wire:ignore>
{{--    wire:poll.5000ms="refresh"--}}
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Minutely Sessions</h3>
            {{--            <a href="javascript:void(0);">View Report</a>--}}
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class=" text-lg">Total</span>

            </p>
            {{--            <p class="ml-auto d-flex flex-column text-right">--}}
            {{--                                    <span class="text-success">--}}
            {{--                                      <i class="fas fa-arrow-up"></i> 12.5%--}}
            {{--                                    </span>--}}
            {{--                <span class="text-bold"> {{$total}}</span>--}}
            {{--            </p>--}}
        </div>
        <!-- /.d-flex -->

        <div class="position-relative mb-4">
            <canvas id="minutes-chart" height="150"></canvas>
        </div>

        {{--        <div class="d-flex flex-row justify-content-end">--}}
        {{--                  <span class="mr-2">--}}
        {{--                    <i class="fas fa-square text-primary"></i> This Week--}}
        {{--                  </span>--}}

        {{--            <span>--}}
        {{--                    <i class="fas fa-square text-gray"></i> Last Week--}}
        {{--                  </span>--}}
        {{--        </div>--}}
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $minutesChart = $('#minutes-chart')
            // eslint-disable-next-line no-unused-vars
            var minutesChart = new Chart($minutesChart, {
                data: {
                    labels: @json($minutes),
                    datasets: @json($dataset)
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            // display: false,
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: false,
                                // suggestedMax: 200
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            });

            Livewire.on('refresh_minutes', (minutes, sessions) => {
                console.log(minutes)
                console.log(sessions)

                minutesChart.data.datasets.forEach((dataset, key) => {
                    dataset.data = sessions[key].data;
                });

                minutesChart.data.labels = minutes;

                minutesChart.update();
            })
        });
    </script>
@endpush


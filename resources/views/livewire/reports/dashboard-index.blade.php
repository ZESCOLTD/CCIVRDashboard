<div class="row">



    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Number of Calls Received</p>
                                <h4 class="my-1 text-info">{{number_format ($total_calls_today->count() ) }}</h4>
{{--                                <p class="mb-0 font-13">{{ number_format( ( ($total_calls_today->count() * 100 )/ ($total_calls_yesterday == 0? 1 :$total_calls_yesterday)),2)  }}% from last week</p>--}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Number of Customers</p>
                                <h4 class="my-1 text-warning">{{number_format($total_customers->count())}}</h4>
                                {{--                                <p class="mb-0 font-13">+8.4% from last week</p>--}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Number of Calls Received Yesterday</p>
                                <h4 class="my-1 text-danger">{{number_format($total_calls_yesterday)}}</h4>
{{--                                <p class="mb-0 font-13">+5.4% from last week</p>--}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Calls This Month</p>
                                <h4 class="my-1 text-success">{{number_format($total_calls_month)}}</h4>
{{--                                <p class="mb-0 font-13">-4.5% from last week</p>--}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class="fa fa-bar-chart"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row ">
            <figure class="col-12 text-center">
{{--                <div id="container"></div>--}}
            </figure>
        </div>


    </div>


</div>


@push('custom-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            console.log( @json($total_calls_today) );

            Highcharts.chart('container', {

                title: {
                    text: 'Self Service on Call - Customer Option Clicks ',
                    align: 'left'
                },

                subtitle: {
                    text: 'number of options clicked on ccivr after customer dials 3636',
                    align: 'left'
                },

                yAxis: {
                    title: {
                        text: 'Number of Option Clicks'
                    }
                },

                xAxis: {
                    accessibility: {
                        rangeDescription: 'Range: 01 to 24'
                    }
                },

                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle'
                },
                    credits: {
                            enabled: false
                        },

                plotOptions: {
                    series: {
                        label: {
                            connectorAllowed: false
                        },
                        pointStart: 1
                    }
                },

                series: [{
                    name: 'Talk to agent',
                    data: [43934, 48656, 65165, 81827, 112143, 142383,
                        171533, 165174, 155157, 161454, 154610]
                }, {
                    name: 'Post Paid',
                    data: [24916, 37941, 29742, 29851, 32490, 30282,
                        38121, 36885, 33726, 34243, 31050]
                }, {
                    name: 'Prepaid',
                    data: [11744, 30000, 16005, 19771, 20185, 24377,
                        32147, 30912, 29243, 29213, 25663]
                }, {
                    name: 'Power Connections',
                    data: [null, null, null, null, null, null, null,
                        null, 11164, 11218, 10077]
                }, {
                    name: 'Report A Fault',
                    data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,21908, 5548, 8105, 11248, 8905, 11248, 8989, 11816, 18274,8989, 11816, 18274,
                        17300, 13053, 11906, 10073]
                }],

                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                layout: 'horizontal',
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }

            });


        {{--Highcharts.chart('summary-calls', {--}}
            {{--    chart: {--}}
            {{--        plotBackgroundColor: null,--}}
            {{--        plotBorderWidth: null,--}}
            {{--        plotShadow: false,--}}
            {{--        type: 'pie',--}}
            {{--        // size: 500--}}
            {{--    },--}}
            {{--    credits: {--}}
            {{--        enabled: false--}}
            {{--    },--}}
            {{--    title: {--}}
            {{--        text: 'Call Summary as of {{date('y-m-d-m-Y-H-i-s')}}, {{number_format($total_calls_today->sum('total'))}}'--}}
            {{--    },--}}
            {{--    subtitle: {--}}
            {{--        text: 'Select a Summary to view breakdown'--}}
            {{--    },--}}

            {{--    accessibility: {--}}
            {{--        announceNewData: {--}}
            {{--            enabled: true--}}
            {{--        },--}}
            {{--        point: {--}}
            {{--            valueSuffix: '%'--}}
            {{--        }--}}
            {{--    },--}}

            {{--    plotOptions: {--}}
            {{--        pie: {--}}
            {{--            allowPointSelect: true,--}}
            {{--            cursor: 'pointer',--}}
            {{--            dataLabels: {--}}
            {{--                enabled: true--}}
            {{--            },--}}
            {{--            showInLegend: true--}}
            {{--        },--}}
            {{--        series: {--}}
            {{--            dataLabels: {--}}
            {{--                enabled: true,--}}
            {{--                format: '{point.my_destination.description}: <b>{point.y}({point.percentage:.1f}%)'--}}
            {{--            }--}}
            {{--        }--}}
            {{--    },--}}

            {{--    tooltip: {--}}
            {{--        headerFormat: '<span style="font-size:11px">{series.my_destination.description}</span><br>',--}}
            {{--        pointFormat: '<span style="color:{point.color}">{point.my_destination.description}</span>: <b>{point.y}</b> of total<br/>'--}}
            {{--    },--}}

            {{--    series: [--}}
            {{--        {--}}
            {{--            name: "Total Count",--}}
            {{--            colorByPoint: true,--}}
            {{--            minPointSize: 10,--}}
            {{--            innerSize: '20%',--}}
            {{--            zMin: 0,--}}
            {{--            data: @json($total_calls_today)--}}
            {{--        }--}}
            {{--    ],--}}
            {{--    --}}{{--drilldown: {--}}
            {{--    --}}{{--    series: @json($backlog_regions_py)--}}
            {{--    --}}{{--}--}}
            {{--});--}}
        });
    </script>

@endpush

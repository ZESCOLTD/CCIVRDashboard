<div class="row">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">
            <div class="col">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-info bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-phone-alt text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Total Calls Today</p>
                                <h3 class="mb-0 text-info">{{number_format($total_calls_today->count())}}</h3>
                                <small class="text-muted">
                                    @php
                                        $percentChange = $total_calls_yesterday == 0 ? 0 :
                                            (($total_calls_today->count() - $total_calls_yesterday) / $total_calls_yesterday) * 100;
                                        $isIncrease = $percentChange >= 0;
                                    @endphp
                                    <span class="{{ $isIncrease ? 'text-success' : 'text-danger' }}">
                                        <i class="fas fa-arrow-{{ $isIncrease ? 'up' : 'down' }}"></i>
                                        {{ number_format(abs($percentChange), 2) }}%
                                    </span>
                                    vs yesterday ({{ number_format($total_calls_yesterday) }})
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-users text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Total Customers</p>
                                <h3 class="mb-0 text-warning">{{number_format($total_customers->count())}}</h3>
                                <small class="text-muted">
                                    @if(isset($total_customers_last_month) && $total_customers_last_month > 0)
                                        @php
                                            $custPercentChange = (($total_customers->count() - $total_customers_last_month) / $total_customers_last_month) * 100;
                                            $custIsIncrease = $custPercentChange >= 0;
                                        @endphp
                                        <span class="{{ $custIsIncrease ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ $custIsIncrease ? 'up' : 'down' }}"></i>
                                            {{ number_format(abs($custPercentChange), 2) }}%
                                        </span>
                                        vs last month ({{ number_format($total_customers_last_month) }})
                                    @else
                                        Active customers in system
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-danger bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-history text-danger fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Yesterday's Calls</p>
                                <h3 class="mb-0 text-danger">{{number_format($total_calls_yesterday)}}</h3>
                                <small class="text-muted">
                                    @if(isset($total_calls_day_before_yesterday) && $total_calls_day_before_yesterday > 0)
                                        @php
                                            $yestPercentChange = (($total_calls_yesterday - $total_calls_day_before_yesterday) / $total_calls_day_before_yesterday) * 100;
                                            $yestIsIncrease = $yestPercentChange >= 0;
                                        @endphp
                                        <span class="{{ $yestIsIncrease ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ $yestIsIncrease ? 'up' : 'down' }}"></i>
                                            {{ number_format(abs($yestPercentChange), 2) }}%
                                        </span>
                                        vs day before ({{ number_format($total_calls_day_before_yesterday) }})
                                    @else
                                        Previous day call volume
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-calendar-alt text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted mb-1">Monthly Calls</p>
                                <h3 class="mb-0 text-success">{{number_format($total_calls_month)}}</h3>
                                <small class="text-muted">
                                    @if(isset($total_calls_last_month) && $total_calls_last_month > 0)
                                        @php
                                            $monthPercentChange = (($total_calls_month - $total_calls_last_month) / $total_calls_last_month) * 100;
                                            $monthIsIncrease = $monthPercentChange >= 0;
                                        @endphp
                                        <span class="{{ $monthIsIncrease ? 'text-success' : 'text-danger' }}">
                                            <i class="fas fa-arrow-{{ $monthIsIncrease ? 'up' : 'down' }}"></i>
                                            {{ number_format(abs($monthPercentChange), 2) }}%
                                        </span>
                                        vs last month ({{ number_format($total_calls_last_month) }})
                                    @else
                                        Current month total
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script>
        $(function() {
            // Enhanced chart with more realistic data and better formatting
            Highcharts.chart('callTrendsChart', {
                chart: {
                    type: 'line',
                    height: 350,
                    backgroundColor: 'transparent'
                },
                title: {
                    text: 'Call Trends Analysis',
                    style: {
                        color: '#333',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    text: 'Year-over-year comparison',
                    style: {
                        color: '#666'
                    }
                },
                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    crosshair: true,
                    labels: {
                        style: {
                            color: '#666'
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Number of Calls',
                        style: {
                            color: '#666'
                        }
                    },
                    gridLineColor: 'rgba(0,0,0,0.05)',
                    labels: {
                        style: {
                            color: '#666'
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    valueSuffix: ' calls',
                    backgroundColor: 'rgba(255,255,255,0.95)',
                    borderColor: '#ddd',
                    borderRadius: 5,
                    shadow: true
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true,
                            format: '{y}',
                            style: {
                                textOutline: 'none',
                                fontWeight: 'normal'
                            }
                        },
                        enableMouseTracking: true,
                        marker: {
                            symbol: 'circle',
                            radius: 5,
                            fillColor: '#fff',
                            lineWidth: 2,
                            lineColor: null // inherit from series color
                        }
                    }
                },
                series: [{
                    name: '{{ now()->subYear()->format("Y") }}',
                    data: [4500, 5200, 4800, 6100, 5900, 6700, 7100, 7500, 6800, 7200, 6900, 8000],
                    color: '#5D87FF',
                    lineWidth: 3
                }, {
                    name: '{{ now()->format("Y") }}',
                    data: [4800, 5500, 5100, 6400, 6200, 7000, 7400, 7800, 7100, 7500, 7200, 8300],
                    color: '#49BEFF',
                    lineWidth: 3,
                    dashStyle: 'Dash'
                }],
                credits: { enabled: false },
                legend: {
                    align: 'right',
                    verticalAlign: 'top',
                    itemStyle: {
                        color: '#333',
                        fontWeight: 'normal'
                    }
                },
                responsive: {
                    rules: [{
                        condition: {
                            maxWidth: 500
                        },
                        chartOptions: {
                            legend: {
                                align: 'center',
                                verticalAlign: 'bottom'
                            }
                        }
                    }]
                }
            });

            // Enhanced pie chart with better formatting
            Highcharts.chart('callDistributionChart', {
                chart: {
                    type: 'pie',
                    height: 350,
                    backgroundColor: 'transparent'
                },
                title: {
                    text: 'Call Type Distribution',
                    style: {
                        color: '#333',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    text: 'Current month breakdown',
                    style: {
                        color: '#666'
                    }
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} calls)'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: '#333',
                                textOutline: 'none',
                                fontWeight: 'normal'
                            },
                            distance: -30,
                            filter: {
                                property: 'percentage',
                                operator: '>',
                                value: 4
                            }
                        },
                        showInLegend: true,
                        borderWidth: 0,
                        shadow: false
                    }
                },
                series: [{
                    name: 'Call Types',
                    colorByPoint: true,
                    innerSize: '40%',
                    data: [{
                        name: 'Talk to Agent',
                        y: 45,
                        color: '#5D87FF'
                    }, {
                        name: 'Post Paid',
                        y: 25,
                        color: '#49BEFF'
                    }, {
                        name: 'Prepaid',
                        y: 15,
                        color: '#FFAE1F'
                    }, {
                        name: 'Power Connections',
                        y: 8,
                        color: '#26BB98'
                    }, {
                        name: 'Report A Fault',
                        y: 7,
                        color: '#FC4F4F'
                    }]
                }],
                credits: { enabled: false },
                legend: {
                    align: 'right',
                    verticalAlign: 'middle',
                    layout: 'vertical',
                    itemStyle: {
                        color: '#333',
                        fontWeight: 'normal'
                    }
                }
            });
        });
    </script>
@endpush

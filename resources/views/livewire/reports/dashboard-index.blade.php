<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .icon-container {
        padding: 1rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.03);
    }

    .icon-container i {
        font-size: 1.75rem;
        opacity: 0.85;
    }

    .card-body p {
        font-size: 0.875rem;
        color: #6c757d;
    }

    .card-body h3 {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .card-body small {
        font-size: 0.75rem;
        display: block;
        margin-top: 0.25rem;
    }

    /* Optional: Placeholder for charts while loading */
    .chart-placeholder {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 350px; /* Match chart height */
        color: #6c757d;
        font-style: italic;
    }
</style>

<div class="row">
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4 mb-4">

            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <div class="icon-container bg-light text-info">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">Total Calls Today</p>
                            <h3 class="text-info mb-0">{{ number_format($total_calls_today_count) }}</h3>
                            <small>
                                @php
                                    $percentChange =
                                        $total_calls_yesterday == 0
                                            ? 0
                                            : (($total_calls_today_count - $total_calls_yesterday) /
                                                $total_calls_yesterday) *
                                                100;
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

            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <div class="icon-container bg-light text-warning">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">Total Customers</p>
                            <h3 class="text-warning mb-0">{{ number_format($total_customers) }}</h3>
                            <small>
                                @if ($total_customers_last_month > 0)
                                    @php
                                        $custPercentChange =
                                            (($total_customers - $total_customers_last_month) /
                                                $total_customers_last_month) *
                                            100;
                                        $custIsIncrease = $custPercentChange >= 0;
                                    @endphp
                                    <span class="{{ $custIsIncrease ? 'text-success' : 'text-danger' }}">
                                        <i class="fas fa-arrow-{{ $custIsIncrease ? 'up' : 'down' }}"></i>
                                        {{ number_format(abs($custPercentChange), 2) }}%
                                    </span>
                                    vs last month ({{ number_format($total_customers_last_month) }})
                                @else
                                    Active customers today
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <div class="icon-container bg-light text-danger">
                                <i class="fas fa-history"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">Yesterday's Calls</p>
                            <h3 class="text-danger mb-0">{{ number_format($total_calls_yesterday) }}</h3>
                            <small>
                                @if ($total_calls_day_before_yesterday > 0)
                                    @php
                                        $yestPercentChange =
                                            (($total_calls_yesterday - $total_calls_day_before_yesterday) /
                                                $total_calls_day_before_yesterday) *
                                            100;
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

            <div class="col">
                <div class="card h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="me-3">
                            <div class="icon-container bg-light text-success">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1">Monthly Calls</p>
                            <h3 class="text-success mb-0">{{ number_format($total_calls_month) }}</h3>
                            <small>
                                @if ($total_calls_last_month > 0)
                                    @php
                                        $monthPercentChange =
                                            (($total_calls_month - $total_calls_last_month) / $total_calls_last_month) *
                                            100;
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


<div class="row">
    <div class="container-fluid">
        <h4 class="mb-4">📈 Call Center Dashboard Charts</h4>

        <div class="row g-4">
            <div class="col-md-6">
                {{-- Add data attributes for chart data --}}
                <div id="call-dst-distribution" class="chart-container" style="height: 350px;"
                    data-chart-type="pie"
                    data-chart-title="Today's Calls by Destination"
                    data-chart-series='@json($todayDstDist->map(fn($row) => ['name' => $row->dst, 'y' => $row->total]))'>
                    <div class="chart-placeholder">Loading Daily Destination Distribution Chart...</div>
                </div>

            </div>
            <div class="col-md-6">
                <div id="hourly-calls" class="chart-container" style="height: 350px;"
                    data-chart-type="column"
                    data-chart-title="Hourly Call Volume (Today)"
                    data-chart-categories='@json($hourlyCalls->pluck('hour')->map(fn($h) => $h . ':00'))'
                    data-chart-series-data='@json($hourlyCalls->pluck('total'))'>
                    <div class="chart-placeholder">Loading Hourly Calls Chart...</div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="daily-calls" class="chart-container" style="height: 350px;"
                    data-chart-type="line"
                    data-chart-title="📞 Daily Call Volume (Last 30 Days)"
                    data-chart-xaxis-title="Date"
                    data-chart-yaxis-title="Total Calls"
                    data-chart-categories='@json($dailyCalls->pluck('date'))'
                    data-chart-series-data='@json($dailyCalls->pluck('total'))'
                    data-chart-color="#007bff">
                    <div class="chart-placeholder">Loading Daily Call Volume Chart...</div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="monthly-calls" class="chart-container" style="height: 350px;"
                    data-chart-type="area"
                    data-chart-title="📆 Monthly Call Trends (Last 12 Months)"
                    data-chart-xaxis-title="Month"
                    data-chart-yaxis-title="Total Calls"
                    data-chart-categories='@json($monthlyCalls->pluck('month'))'
                    data-chart-series-data='@json($monthlyCalls->pluck('total'))'
                    data-chart-color="#28a745">
                    <div class="chart-placeholder">Loading Monthly Calls Chart...</div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="daily-customers" class="chart-container" style="height: 350px;"
                    data-chart-type="column"
                    data-chart-title="👥 Unique Customers per Day"
                    data-chart-xaxis-title="Date"
                    data-chart-yaxis-title="Customers"
                    data-chart-categories='@json($dailyCustomers->pluck('date'))'
                    data-chart-series-data='@json($dailyCustomers->pluck('total'))'
                    data-chart-color="#ffc107">
                    <div class="chart-placeholder">Loading Daily Customers Chart...</div>
                </div>
            </div>

        </div>
    </div>
</div>


@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/pie.js"></script>
    <script src="https://code.highcharts.com/modules/column.js"></script>


    <script>
        document.addEventListener('livewire:load', function() {
            const chartContainers = document.querySelectorAll('.chart-container');
            let loadQueue = [];
            let isProcessingQueue = false;

            // Function to initialize a single chart
            function initializeChart(container) {
                const chartType = container.dataset.chartType;
                const chartTitle = container.dataset.chartTitle;
                const chartCategories = container.dataset.chartCategories ? JSON.parse(container.dataset.chartCategories) : [];
                const chartSeriesData = container.dataset.chartSeriesData ? JSON.parse(container.dataset.chartSeriesData) : [];
                const chartColor = container.dataset.chartColor;
                const chartXaxisTitle = container.dataset.chartXaxisTitle;
                const chartYaxisTitle = container.dataset.chartYaxisTitle;
                const chartPieSeries = container.dataset.chartSeries ? JSON.parse(container.dataset.chartSeries) : [];

                // Remove the placeholder
                const placeholder = container.querySelector('.chart-placeholder');
                if (placeholder) {
                    placeholder.remove();
                }

                // Initialize Highcharts based on chart type and data
                switch (chartType) {
                    case 'line':
                    case 'area':
                    case 'column':
                        Highcharts.chart(container.id, {
                            chart: {
                                type: chartType
                            },
                            title: {
                                text: chartTitle
                            },
                            xAxis: {
                                categories: chartCategories,
                                title: {
                                    text: chartXaxisTitle
                                }
                            },
                            yAxis: {
                                title: {
                                    text: chartYaxisTitle
                                }
                            },
                            series: [{
                                name: 'Calls', // Default name, adjust as needed or pass dynamically
                                data: chartSeriesData,
                                color: chartColor
                            }]
                        });
                        break;
                    case 'pie':
                        Highcharts.chart(container.id, {
                            chart: {
                                type: 'pie'
                            },
                            title: {
                                text: chartTitle
                            },
                            series: [{
                                name: 'Calls',
                                colorByPoint: true,
                                data: chartPieSeries
                            }]
                        });
                        break;
                    default:
                        console.warn(`Unknown chart type: ${chartType}`);
                        break;
                }
            }

            // Function to process the queue with a delay
            function processQueue() {
                if (loadQueue.length > 0 && !isProcessingQueue) {
                    isProcessingQueue = true;
                    // Sort the queue by DOM order to ensure sequential loading visually
                    loadQueue.sort((a, b) => {
                        const positionA = a.getBoundingClientRect().top;
                        const positionB = b.getBoundingClientRect().top;
                        return positionA - positionB;
                    });

                    const processNextChart = () => {
                        if (loadQueue.length > 0) {
                            const container = loadQueue.shift();
                            initializeChart(container);
                            observer.unobserve(container); // Stop observing once loaded
                            setTimeout(processNextChart, 200); // Small delay between charts
                        } else {
                            isProcessingQueue = false;
                        }
                    };
                    processNextChart();
                }
            }


            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const container = entry.target;
                        // Add to queue only if not already processed
                        if (!container.dataset.chartLoaded) {
                            loadQueue.push(container);
                            container.dataset.chartLoaded = 'true'; // Mark as added to queue
                            processQueue(); // Try to process the queue immediately
                        }
                    }
                });
            }, {
                rootMargin: '0px',
                threshold: 0.1
            });

            // Observe each chart container
            chartContainers.forEach(container => {
                observer.observe(container);
            });
        });
    </script>
@endpush
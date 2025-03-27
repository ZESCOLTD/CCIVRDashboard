<div class="row">


    <div class="container">

        <div class="card card-body">

            <form wire:submit.prevent="search">
                <div class="row d-flex">
                    <div class="col d-flex">
                        <label class="mr-2" for="from">From: </label>
                        <input type="datetime-local" class="form-control" id="from" placeholder="Enter Date"
                            wire:model.defer="from">
                        @error('context')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col d-flex">
                        <label class="mr-2" for="to">To: </label>
                        <input type="datetime-local" class="form-control" id="to" placeholder="Enter Date"
                            wire:model.defer="to">
                        @error('context')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col">
                        <button type="submit" class="btn btn-success btn-block">
                            <div wire:loading>
                                <span class="spinner-border spinner-border-sm mr-4" role="status"
                                    aria-hidden="true"></span>
                            </div>
                            <span class="mr-4">Search</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <span>Records from {{ $from }} to {{ $to }}</span>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">

                <div class="card radius-10 border-start border-0 border-3 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Number of Calls Received</p>
                                <h4 class="my-1 text-info">{{ number_format($summary_calls_today->sum('y')) }}</h4>
                                {{--                                <p class="mb-0 font-13">{{ number_format( ( ($summary_calls_today->sum('y') * 100 )/ ($total_calls_yesterday->count()==0?1:$total_calls_yesterday->count() )),2)  }}% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i
                                    class="fa fa-shopping-cart"></i>
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
                                <p class="mb-0 text-secondary">Number of Customers</p>
                                <h4 class="my-1 text-danger">{{ number_format($summary_calls_customers->count()) }}</h4>
                                {{--                                <p class="mb-0 font-13">+5.4% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                    class="fa fa-dollar"></i>
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
                                <h4 class="my-1 text-danger">{{ number_format($total_calls_yesterday->sum('y')) }}</h4>
                                {{--                                <p class="mb-0 font-13">+5.4% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
                                    class="fa fa-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="row ">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <h1>Summary Graph for {{ $src }}</h1>
                    </div>
                    <div class="card-body">

                        <div id="summary-calls"></div>

                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                    <h1>Summary Graph for {{ $src }}</h1>
                    </div>

                    <div class="card-body">

                        {{-- <livewire:c-s-r-model/> --}}
                        <table>
                            <tr>
                                <th>Option</th>
                                <th>Description</th>
                                
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Duration</th>
                                <th>Last App</th>
                            </tr>
                            <tbody>
                                @foreach ($customerJourneys as $customerJourney)
                                    <tr>
                                        <td>{{ $customerJourney->myDestination->option }}</td>
                                        <td>{{ $customerJourney->myDestination->description }}</td>
                                        
                                        <td>{{ $customerJourney->calldate }}</td>
                                        <td>{{ $customerJourney->hangupdate }}</td>
                                        <td>{{ $customerJourney->duration }}</td>
                                        <td>{{ $customerJourney->lastapp }}</td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>


    </div>




</div>

@push('custom-scripts')
    @livewireScripts
    <script type="text/javascript">
        window.chartData = @json($summary_calls_today);
        window.summaryTotal = {{ number_format($callsToday) }};
        {{-- window.date = {{date('y-m-d-m-Y-H-i-s')}}; --}}

        $(document).ready(function() {
            graph();
        });


        Livewire.on('dataUpdate', function(data) {
            window.chartData = data['summary_calls_today'];
            //console.log( window['chartData'] );
            let sum = 0
            $.each(data.summary_calls_customers, function(index, ele) {
                sum += ele.total;
                //console.log('ele.total', ele.total);
            });
            //   console.log('calls summary', sum);

            window.summaryTotal = sum; //number_format($summary_calls_today->sum('total'));
            // window.date = data?.mydate;//date('y-m-d-m-Y-H-i-s');
            graph();
        });

        function graph() {
            console.log('summaryTotal', window['summaryTotal']);

            Highcharts.chart('summary-calls', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie',
                    // size: 500
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Call Summary total ' + window['summaryTotal']
                },
                subtitle: {
                    text: 'Select a Summary to view breakdown'
                },

                accessibility: {
                    announceNewData: {
                        enabled: true
                    },
                    point: {
                        valueSuffix: '%'
                    }
                },

                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true
                        },
                        showInLegend: true
                    },
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '{point.my_destination.description}: <b>{point.y}({point.percentage:.1f}%)'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{point.my_destination.description}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.my_destination.description}</span>: <b>{point.y}</b> of total<br/>'
                },

                legend: {
                    enabled: true,
                    labelFormatter: function() {
                        return this.my_destination.description;
                    }
                },

                series: [{
                    name: "Total Count",
                    colorByPoint: true,
                    minPointSize: 10,
                    innerSize: '20%',
                    zMin: 0,
                    data: window['chartData']
                }],
            });

        }
    </script>
@endpush

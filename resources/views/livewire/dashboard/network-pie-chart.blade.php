<div class="card" >
    <div class="card-header border-0">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">Network Sessions</h3>
{{--            <a href="javascript:void(0);">View Report</a>--}}
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                <span class=" text-lg">Total</span>

            </p>
            <p class="ml-auto d-flex flex-column text-right">
{{--                    <span class="text-success">--}}
{{--                      <i class="fas fa-arrow-up"></i> 12.5%--}}
{{--                    </span>--}}
                <span class="text-bold"> {{$total}}</span>
            </p>
        </div>
        <!-- /.d-flex -->

        <div class="position-relative mb-4">
            <canvas id="network-chart" height="150"></canvas>
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
        $( document ).ready(function() {
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true

            var $networkChart = $('#network-chart')
            data = {
                datasets: [{
                    data: @json($data),
                    backgroundColor: [
                        '#F70000',
                        '#FFCB05',
                        '#34B7F1',
                        '#20AC49',

                    ],
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: @json($labels),

            };

            var myPieChart = new Chart($networkChart, {
                type: 'pie',
                data: data,
            });

        });
    </script>
@endpush

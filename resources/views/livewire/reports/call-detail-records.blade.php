<div class="row">

    <div class="container">
        <div class="card card-body">


            <form wire:submit.prevent="search">
                <div class="row d-flex">
                    <div class="col d-flex">
                        <label for="from">From:</label>
                        <input type="datetime-local" class="form-control" id="from" placeholder="Enter Date"
                            wire:model.defer="from">
                        @error('from')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col d-flex">
                        <label for="to">To:</label>
                        <input type="datetime-local" class="form-control" id="to" placeholder="Enter Date"
                            wire:model.defer="to">
                        @error('to')
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
    </div>

    <div class="container">



        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Calls Today</p>
                                <h4 class="my-1 text-info">{{ number_format($total_calls_today->total()) }}</h4>
                                {{--                                <p class="mb-0 font-13">{{ number_format( ( ($total_calls_today->count() * 100 )/ ($total_calls_yesterday == 0? 1 :$total_calls_yesterday)),2)  }} --}}
                                {{--                                    % from last week</p> --}}
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
                                <p class="mb-0 text-secondary">Total Calls Yesterday</p>
                                <h4 class="my-1 text-danger">{{ number_format($total_calls_yesterday) }}</h4>
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
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total Calls This Month</p>
                                <h4 class="my-1 text-success">{{ number_format($total_calls_month) }}</h4>
                                {{--                                <p class="mb-0 font-13">-4.5% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                    class="fa fa-bar-chart"></i>
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
                                <p class="mb-0 text-secondary">Total Calls Year</p>
                                <h4 class="my-1 text-warning">{{ number_format($total_calls_year) }}</h4>
                                {{--                                <p class="mb-0 font-13">+8.4% from last week</p> --}}
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i
                                    class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="w-full flex pb-10">
                            <h2>Search by Caller Number</h2>
                            <div class="w-3/6 mx-1">
                                <input wire:model.debounce.300ms="src" type="text"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search Callers...">
                            </div>
                            <div class="w-1/6 relative mx-1">
                                <select wire:model.defer="src_mod"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                    <option value="contains" selected="selected">Contains</option>
                                    <option value="begins_with">Begins with</option>
                                    <option value="ends_with">Ends with</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- <div class="w-1/6 relative mx-1">
                    <select wire:model="orderBy" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                        <option value="id">ID</option>
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                        <option value="created_at">Sign Up Date</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div> --}}
                            <div class="w-1/6 relative mx-1">
                                <select wire:model.defer="orderAsc"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                    <option value="1">Ascending</option>
                                    <option value="0">Descending</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-1/6 relative mx-1">
                                <select wire:model.defer="perPage"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                    <option>5</option>
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                    <option>100</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="w-full flex pb-10">

                            <h2>Search by Option</h2>
                            <div class="w-1/6 relative mx-1">
                                <select wire:model.debounce.300ms="dst"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                    <option value="">All</option>
                                    <option value="cc-3">Option 1 (Faults Reporting)</option>
                                    <option value="cc-7">Option 2 (Faults Tracking)</option>
                                    <optgroup label="Option 3">
                                        <option value="cc-13">Option 3-1 (To Reiceive Previous token)</option>
                                        <option value="cc-15">Option 3-2 (Update prepaid meter)</option>
                                        <option value="cc-20">Option 3-2 (Key change tokens)</option>
                                    </optgroup>
                                    <option value="cc-6">Option 4 (Post-paid Services)</option>
                                    <optgroup label="Option 5">
                                        <option value="cc-18">Option 5-1 (New power connection)</option>
                                        <option value="cc-4">Option 5-2 (New Connections tatus)</option>
                                    </optgroup>
                                    <optgroup label="Option 6">
                                        <option value="cc-14">Option 5-1(SMS registration)</option>
                                        <option value="cc-8">Option 5-2(USSD)</option>
                                        <option value="cc-9">Option 5-3(Website)</option>
                                        <option value="cc-10">Option 5-4(WhatsApp)</option>
                                        <option value="cc-11">Option 5-5(Mobile app)</option>
                                        <option value="cc-12">Option 5-6(Mobile App)</option>
                                    </optgroup>
                                    <option value="cc-17">Option 7(Speak to an agent)</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-1/6 relative mx-1">
                                <select wire:model.defer="orderAsc"
                                    class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="grid-state">
                                    <option value="1">Ascending</option>
                                    <option value="0">Descending</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                            {{-- <div class="w-1/6 relative mx-1">
                    <select wire:model="perPage"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="grid-state">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div> --}}
                        </div>
                        <div class="w-full flex pb-10">

                            <h2>Search by Call Duration</h2>
                            <div class="w-3/6 mx-1">
                                <input wire:model.debounce.300ms="dur_min" type="text" placeholder="Min Duration"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search Callers...">
                            </div>
                            <div class="w-3/6 mx-1">
                                <input wire:model.debounce.300ms="dur_max" type="text" placeholder="Max Duration"
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"placeholder="Search Callers...">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        Latest {{ $total_calls_today->count() }} Calls out of {{ $total_calls_today->total() }}
                        Calls Today
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="cdr-table" class="table table-bordered">
                                <thead>

                                    <tr>
                                        <th>Item</th>
                                        <th>Caller</th>
                                        <th>Destination</th>
                                        <th>Dest Context</th>
                                        <th>Description</th>
                                        <th>Caller ID</th>
                                        <th>Channel</th>
                                        <th>Last App</th>
                                        <th>Last Data</th>
                                        <th>Call Date</th>
                                        <th>Answer Date</th>
                                        <th>Hungup Date</th>
                                        <th>Duration</th>
                                        <th>Bill Seconds</th>
                                        <th>Disposition</th>
                                        <th>Action</th>
                                    </tr>

                                </thead>
                                <tbody>


                                    @if ($total_calls_today->total() > 0)
                                        @foreach ($total_calls_today as $total_call_today)
                                            <tr>
                                                <td>
                                                    {{ $total_call_today->id }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->src }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->dst }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->dcontext }}
                                                </td>

                                                <td>
                                                    {{ $total_call_today->myDestination->description ?? '--' }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->clid }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->channel }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->lastapp }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->lastdata }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->calldate }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->answerdate }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->hangupdate }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->duration }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->billseconds }}
                                                </td>
                                                <td>
                                                    {{ $total_call_today->disposition }}
                                                </td>

                                                <td>
                                                    {{--                                                <a href="{{route('reports.show.cdr', ['id' => $total_call_today->id ] )}}"  class="btn btn-success btn-sm">Show {{$total_call_today->id}}</a> --}}
                                                    <button data-toggle="modal" data-target="#showModal"
                                                        wire:click="show({{ $total_call_today->id }})"
                                                        class="btn btn-primary btn-sm">View
                                                    </button>
                                                    {{--                                                <button onclick="deleteConfigDestination({{$total_call_today->id}})" class="btn btn-danger btn-sm">Delete</button> --}}
                                                    {{--                                                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" --}}
                                                    {{--                                                        data-target="#createModal"> --}}
                                                    {{--                                                    <i class="fa fa-plus">Add</i> --}}
                                                    {{--                                                </button> --}}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @include('livewire.reports.CallDetailsRecord.view-cdr')
                                    @else
                                        <tr>
                                            <td colspan="3" align="center">
                                                No Calls Found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <div>
                                {{ $total_calls_today->links() }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>




    </div>



</div>

@push('custom-scripts')
    <script type="text/javascript">
        // new DataTable('#cdr-table');
    </script>
@endpush

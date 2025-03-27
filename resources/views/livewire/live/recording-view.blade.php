<div>




    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span class="text-bold text-orange">Date Fileter </span>
                </div>
                <div class="card-body">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <form wire:submit.prevent="render" method="GET" class="w3-light-grey  w3-container w3-padding-16">
        <div class="w3-cell-row">
            <div class="w3-cell w3-container"><input value = "{{ 'Agent' }}" type="text"
                    class="w3-input w3-round" name="agent" id="agent" placeholder="Agent ID"></div>
            <div class="w3-cell w3-container"><input type="text" class="w3-input w3-round"
                    name = "phone_number" placeholder="Phone number: Ex. 0612345678"></div>
            <div class="w3-cell w3-container"><input type="text" class="w3-input w3-round" name="lead_id"
                    placeholder="Lead ID"></div>
        </div>
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
                <button type="submit" class="btn btn-block btn-outline-success">
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

        </div>
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span class="text-bold text-orange">Recording List </span>
                </div>
                <div class="card-body">
                    <div class="card-body">
                        <div class="w3-content w3-margin-bottom">
                            <div class="table-responsive">
                                <table class="table" id="myTable" class="w3-table w3-bordered w3-small">
                                    <thead>
                                        <tr class="w3-medium">
                                            <th>Recording ID</th>
                                            {{-- <th>Lead ID</th> --}}
                                            <th>Phone Number</th>
                                            <th>Agent </th>
                                            <th>Date</th>
                                            {{-- <th>Duration (sec) </th> --}}
                                            <th>Actions</th>
                                            {{-- <th>Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>



                                        @foreach ($recordings as $recording)


                                            <tr>
                                                <td>{{ $recording->id }} </td>
                                                {{-- <td><a target=_blank href= ' .lead_id '>{{ $recording->id }}</a></td> --}}
                                                <td> {{ $recording->phone_number }}</td>

                                                {{-- str_replace("SIP/7000/","",$recording->agent_number); --}}
                                                <td><a href="{{ $recording->agent_number }}">
                                                        {{ str_replace('SIP/7000/', '', $recording->agent_number) }}</a>
                                                </td>
                                                <td>{{ $recording->created_at ?? '--' }}</td>
                                                {{-- <td>{{ $recording->duration }}</td> --}}
                                                <td>

                                                    <div class="d-inline">


                                                        {{-- <audio controls style="vertical-align: middle"
                                                            title='{{ $recording->file_name }}'
                                                            src="{{ url("audio", ['file'=>$recording->file_name,'extension'=>'wav'])}}"
                                                            type="audio/wave" >
                                                            Your browser does not support the audio element.
                                                        </audio> --}}

                                                    </div>

                                                    <a class="btn btn-sm btn-outline-success" href="">Listen</a>


                                                    {{-- <button wire:click="download" wire:model.defer="to">
                                                                Download File
                                                            </button> --}}
                                                </td>
                                                {{-- <td>{{ $recording->file_name }} </td> --}}
                                                {{-- <td><a href="https://zqa1.zesco.co.zm/audio/015a8970-b4a4-1f93-95b2-ad8278d0110a/wav">{{ $recording->file_name }}</a> </td> --}}
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
    </div>













    </div>

    @push('custom-scripts')
        <script type="text/javascript">
            new DataTable('#myTable');
        </script>

        {{-- <script type="text/javascript">
            setInterval(function() {
                location.reload();
            }, 60000); // 60,000 milliseconds = 60 seconds
        </script> --}}
    @endpush

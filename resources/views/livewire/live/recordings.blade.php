<div>

    <div class="card">
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

    <div class="card">
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

                            {{--  "id" => 21
        "agent_number" => "SIP/7000/2035"
        "phone_number" => "6002"
        "duration_number" => "2024-03-13 07:34:57.033Z"
        "file_name" => "6dee8680-e711-1f90-9e2c-51daef07d0df"
        "file_path" => "6dee8680-e711-1f90-9e2c-51daef07d0df"
        "created_at" => "2024-04-30 08:26:56"
        "updated_at" => "2024-04-30 08:26:56" --}}


                            @foreach ($recordings as $recording)
                                {{-- $agent = $recordings[$i]['user']; --}}
                                {{-- $lead_id = '../vicidial/admin_modify_lead.php?lead_id='. $recordings[$i]['lead_id'].'&archive_search=No&archive_log=0'; --}}
                                {{-- <tr><td>{{" recordings[i][recording_i]"}} </td>
                               <td><a target=_blank href= ' .lead_id '>{{"recordings[i]['lead_id']"}}</a></td>
                               <td> {{"phone_number(recordings[i]['filename'])"}}</td>
                               <td><a href="../vicidial/admin.php?ADD=3&user= '. $agent . '"> {{"agent . "}}</a></td>
                               <td>{{"recordings[i][start_time]"}}</td>
                               <td>{{"recordings[i]['length_in_sec'] . "}}</td>
                               <td>
                                    <a href="'. $recordings[$i]['location'] .'" target=_blank><i class="fas fa-headphones w3-text-indigo"></i></a><a download href="'. $recordings[$i]['location'] .'" ><i class="fas fa-file-download w3-margin-left w3-text-indigo"></i></a> </td>';
                               </tr> --}}

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
                                        {{-- <span>{{ $recording->file_name }}</span> --}}
                                        {{-- <span><audio controls>
                                            <source src="storage/{{$recording->file_name.".wav"}}" type="audio/wav">
                                            </audio></span> --}}

                                        {{-- <audio controls="" style="vertical-align: middle" src="audio/{{ $recording->file_name }}/wav" type="audio/wav" controlslist="nodownload">
                                                Your browser does not support the audio element.
                                            </audio> --}}
                                        <div class="d-inline">

                                            {{-- <audio controls style="vertical-align: middle"
                                                title='{{ $recording->file_name }}'
                                                src="https://zqa1.zesco.co.zm/audio/{{ $recording->file_name }}/wav"
                                                type="audio/wave" {{-- controlslist="nodownload">
                                                Your browser does not support the audio element.
                                            </audio> --}}
                                            <audio controls style="vertical-align: middle"
                                                title='{{ $recording->file_name }}'
                                                src="{{ url("audio", ['file'=>$recording->file_name,'extension'=>'wav'])}}"
                                                type="audio/wave" {{-- controlslist="nodownload" --}}>
                                                Your browser does not support the audio element.
                                            </audio>
                                            {{-- <span>
                                                <a wire:click.prevent="download({{ $recording->id }})"
                                                    wire:loading.attr="disabled" wire:target="download"
                                                    style="cursor: pointer; margin-left: 10px;">
                                                    <i class="fas fa-file-download w3-text-indigo"></i>
                                                </a>
                                            </span> --}}
                                        </div>

                                        {{-- <a href="{{storage_path("app/public/{$recording->file_path}.wav")}}">Listen</a> --}}


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
                    <div>
                        {{ $recordings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    <script type="text/javascript">
        // AppraisalSystemv2/app/Http/Livewire/Appraisee/AppraiseeIndex.php
        new DataTable('#myTable');
    </script>

    {{-- <script type="text/javascript">
        setInterval(function() {
            location.reload();
        }, 60000); // 60,000 milliseconds = 60 seconds
    </script> --}}
@endpush

<div>
    <div class="col-md-8 mb-2">
        <div class="card">
            <div class="card-body">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
                @endif

                <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                    data-target="#createModal">
                    <i class="fa fa-plus">Add</i>
                </button>


                @include('livewire.session.create')

                {{-- @include('livewire.session.edit') --}}

            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Time from</th>
                                <th>Time to</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($sessions) > 0)
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>
                                            {{ $session->name }}
                                        </td>
                                        <td>
                                            {{ $session->description }}
                                        </td>

                                        <td>
                                            {{ $session->time_from }}
                                        </td>
                                        <td>
                                            {{ $session->time_to }}
                                        </td>
                                        <td>
                                            <a href="{{ route('session.call-sessions.show', ['id' => $session->id]) }}"
                                                class="btn btn-success btn-sm">View</a>
                                            {{-- <button data-toggle="modal"
                                                data-target="#updateModal" wire:click="edit({{$session->id}})" class="btn btn-primary btn-sm">Edit</button>
                                        <button onclick="deleteConfigDestination({{$session->id}})" class="btn btn-danger btn-sm">Delete</button> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No Destinations Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteConfigContext(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteConfigContext', id);
        }
    </script>
</div>

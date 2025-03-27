<div>
    <div class="col-md-8 mb-2">
        <div class="card">
            <div class="card-body">
                @if(session()->has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->get('error') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">

            <div class="card-header">
                {{$context->context}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Context</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($context->destinations) > 0)
                            @foreach ($context->destinations as $config_destination)
                                <tr>
                                    <td>
                                        {{$config_destination->myContext->context}}
                                    </td>
                                    <td>
                                        {{$config_destination->destination}}
                                    </td>
                                    <td>
                                        {{$config_destination->description}}
                                    </td>
                                    <td>
                                        <button data-toggle="modal"
                                                data-target="#updateModal" wire:click="edit({{$config_destination->id}})" class="btn btn-primary btn-sm">Edit</button>
                                        <button onclick="deleteConfigDestination({{$config_destination->id}})" class="btn btn-danger btn-sm">Delete</button>
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
        function deleteConfigContext(id){
            if(confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteConfigContext',id);
        }
    </script>
</div>

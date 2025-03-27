<div>
    <div class="col-md-12 mb-2">
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

                    <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                            data-target="#createModal">
                        <i class="fa fa-plus">Add</i>
                    </button>


                    @include('livewire.configs.contexts.update')

                    @include('livewire.configs.contexts.create')

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Context</th>
                            <th>Destinations</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($config_contexts) > 0)
                            @foreach ($config_contexts as $config_context)
                                <tr>
                                    <td>
                                        {{$config_context->context}}
                                    </td>
                                    <td>
                                        {{$config_context->destinations->count() }}
                                    </td>
                                    <td>
                                        <a href="{{route('config.show.contexts', ['id' => $config_context->id ] )}}"  class="btn btn-success btn-sm">Show</a>
                                        <button data-toggle="modal"
                                                data-target="#updateModal" wire:click="edit({{$config_context->id}})" class="btn btn-primary btn-sm">Edit</button>
                                        <button onclick="deleteConfigDestination({{$config_context->id}})" class="btn btn-danger btn-sm">Delete</button>
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

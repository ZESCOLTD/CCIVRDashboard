<div class="container mt-5">

    <div class="col-md-12 mb-2">
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


                @include('livewire.live.transaction-code.delete')

                @include('livewire.live.transaction-code.update')

                @include('livewire.live.transaction-code.create')

            </div>
        </div>
    </div>


    <div class="card  m-2 p-2">

        <div class="table-responsive">
            <table class="table  table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionCodes as $transactionCode)
                        <tr>
                            <td>{{ $transactionCode->code }}</td>
                            <td>{{ $transactionCode->name }}</td>
                            <td>{{ $transactionCode->description }}</td>
                            <td>{{ $transactionCode->created_at }}</td>
                            <td>{{ $transactionCode->updated_at }}</td>
                            <td><button type="button" class="btn btn-sm btn-outline-success"
                                    wire:click="edit({{ $transactionCode->id }})" data-toggle="modal"
                                    data-target="#updateModal">
                                    <i class="fa fa-plus">Edit</i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    wire:click="edit({{ $transactionCode->id }})" data-toggle="modal"
                                    data-target="#deleteModal">
                                    <i class="fa fa-plus">Delete</i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

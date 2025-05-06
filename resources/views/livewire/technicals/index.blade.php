<div>
{{--    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.dataTables.min.css" />--}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">


    <div class="col-md-10 mb-2">
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
                    @livewireStyles

                <div class="row">
                    <div class="col-sm-6">
                        <h3>Knowledge Base Management Portal</h3>
                    </div>
                    <div class="col-sm-4">
                        <button type="button" class="btn btn-neutral btn-outline-success" data-bs-toggle="modal"
                                data-bs-target="#createModal" wire:click.prevent="resetFields()">
                            <i class="fa fa-plus"> Create Knowledge Base Management</i>
                        </button>
                    </div>
                </div>

                @include('livewire.technicals.update')
                @include('livewire.technicals.create')
            </div>
        </div>
    </div>

    <div class="col-md-10">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="technicalsTable" style="width:100%">                        <thead>
                        <tr>
                            <th width="30%">TOPIC</th>
                            <th width="50%">DESCRIPTION</th>
                            <th width="20%">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($technicals as $technical)
                            <tr>
                                <td>{{ $technical->topic ?? '' }}</td>
                                <td>{{ $technical->description ?? '' }}</td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#updateModal"
                                            wire:click="edit({{ $technical->id }})"
                                            class="btn btn-primary btn-sm">Edit
                                    </button>
                                    <button onclick="deleteTechnical({{ $technical->id }})"
                                            class="btn btn-danger btn-sm">Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No Records Found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
    <script>
        function deleteTechnical(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteTechnical', id);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Include DataTables JavaScript -->
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function () {
            $('.table').DataTable();
        });
    </script>
</div>

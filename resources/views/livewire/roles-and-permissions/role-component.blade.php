<div>
    <div class="row">

        <div class="container mt-5">
            <!-- Navigation Buttons -->
            <a href="{{ url('roles') }}" class="btn btn-primary mx-1">Roles</a>
            <a href="{{ url('permissions') }}" class="btn btn-info mx-1">Permissions</a>
            <a href="{{ url('users') }}" class="btn btn-warning mx-1">Users</a>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                    @endif

                    <!-- Roles Card -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Roles
                                <!-- Add Role Button for Authorized Users -->
                                @can('create role')
                                <a href="{{ url('roles/create') }}" class="btn btn-primary float-end">Add Role</a>
                                @endcan
                            </h4>
                        </div>

                        <div class="card-body">
                            <!-- Roles Table -->
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
{{--                                        <th>Id</th>--}}
                                        <th>Name</th>
                                        <th width="40%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
{{--                                        <td>{{ $role->id }}</td>--}}
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <!-- Add / Edit Permissions Button -->
                                            <a href="{{ url('roles/'.$role->id.'/give-permissions') }}" class="btn btn-warning">Add / Edit Role Permission</a>

                                            <!-- Edit Role Button for Authorized Users -->
                                            @can('update role')
                                            <a href="{{ url('roles/'.$role->id.'/edit') }}" class="btn btn-success">Edit</a>
                                            @endcan

                                            <!-- Delete Role Button for Authorized Users -->
                                            @can('delete role')
                                            <a href="{{ url('roles/'.$role->id.'/delete') }}" class="btn btn-danger mx-2">Delete</a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div>
                                {{ $roles->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

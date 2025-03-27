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

                    {{-- <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                            data-target="#createModal">
                        <i class="fa fa-plus">Add</i>
                    </button> --}}
                    <a href="{{route('user.create')}}" class="btn btn-sm btn-outline-success">
                        <i class="far fa-user nav-icon"> Add User</i>
                    </a>

{{--
                    @include('livewire.configs.contexts.update')

                    @include('livewire.configs.contexts.create') --}}

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th>man_no</th>
                                <th>name</th>
                                <th>position</th>
                                <th>job_title</th>
                                <th>email</th>
                            </tr>

                        </thead>
                        <tbody>


                            @if (count($users) > 0)
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->man_no }}
                                        </td>
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->position }}
                                        </td>
                                        <td>
                                            {{ $user->job_title }}
                                        </td>

                                        <td>
                                            {{ $user->email}}
                                        </td>

                                        <td>
                                             <a href="{{route('user.show', ['id' => $user->id ] )}}"  class="btn btn-success btn-sm">Show </a>
                                            {{-- <button data-toggle="modal" data-target="#showModal"
                                                wire:click="({{ $user->id }})"
                                                class="btn btn-primary btn-sm">View
                                            </button> --}}
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
                        {{ $users->links() }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

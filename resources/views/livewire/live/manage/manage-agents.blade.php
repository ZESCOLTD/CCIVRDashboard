<div>

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
                    <i class="fa fa-plus">Add Agent</i>
                </button>

                <button type="button" wire:click="getSetNumbers()" class="btn btn-sm btn-outline-info">
                    <!-- The button content changes based on loading state -->
                    <span wire:loading.remove>
                        <i class="fa fa-sync"></i> Get Set Numbers
                    </span>
                    <!-- Spinner displayed when loading -->
                    <span wire:loading>
                        <i class="fa fa-spinner fa-spin"></i> Fetching...
                    </span>
                </button>

                @include('livewire.live.manage.create')

            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">

            <div class="card-header">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search by phone number or agent..."
                        wire:model.debounce.300ms="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <th>Name</th>
                                <th>Agent Number</th>
                                <th>Number</th>
                                <th>Set Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody>


                            @if (count($agents) > 0)
                                @foreach ($agents as $agent)
                                    <tr>
                                        <td>
                                            {{ $agent->name }}
                                        </td>
                                        <td>
                                            {{ $agent->endpoint }}
                                        </td>
                                        <td>
                                            {{ $agent->number }}
                                        </td>
                                        <td>
                                            {{ $agent->set_number }}
                                        </td>

                                        <td>
                                            {{ $agent->state }}
                                        </td>

                                        <td>
                                            <a href="{{ route('live.agent.show', ['id' => $agent->id]) }}"
                                                class="btn btn-success btn-sm">View </a>

                                        </td>
                                    </tr>
                                @endforeach
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
                        {{ $agents->links() }}
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

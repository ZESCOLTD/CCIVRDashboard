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
                                <th>Man Number</th>
                                <th>Email</th>
                                <th>State</th>
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
                                            {{ $agent->man_no }}
                                        </td>
                                        <td>
                                            {{ $agent->email }}
                                        </td>

                                        <td>
                                            {{ $agent->state }}
                                        </td>
                                        <td>
                                            {{ $agent->status }}
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


@push('custom-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('[Livewire] livewire:load fired ✅');



            document.addEventListener('closeModal', function() {
                console.log('[Livewire] livewire:closeModal fired ✅');

                // const creatModal = bootstrap.Modal.getInstance('createModal');
                // creatModal.hide(); // Use native Bootstrap API

                const createModalElement = document.getElementById('createModal');
                if (createModalElement) {
                    createModalElement.style.display = 'none'; // Hide the element
                    createModalElement.classList.remove('show'); // Remove Bootstrap's 'show' class
                    document.body.classList.remove('modal-open'); // Remove body class to fix scrolling
                    const backdrop = document.querySelector('.modal-backdrop'); // Remove backdrop if exists
                    if (backdrop) {
                        backdrop.remove();
                    }
                }
            });

        });
    </script>
@endpush

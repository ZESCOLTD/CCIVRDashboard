<div class="container mt-4">
    <h2 class="mb-3">Permissions</h2>

    @if (session()->has('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" wire:model="search" class="form-control" placeholder="Search permissions...">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ $isEditing ? 'Edit Permission' : 'New Permission' }}</label>
                        <input type="text" wire:model="name" class="form-control" placeholder="Permission name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            {{ $isEditing ? 'Update' : 'Create' }}
                        </button>
                        @if ($isEditing)
                            <button type="button" wire:click="resetInput" class="btn btn-secondary">
                                Cancel
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
        <tr>
            <th>Name</th>
            <th style="width: 160px;">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($permissions as $permission)
            <tr>
                <td>{{ $permission->name }}</td>
                <td>
                    <button wire:click="edit({{ $permission->id }})" class="btn btn-sm btn-warning">
                        Edit
                    </button>
                    <button wire:click="destroy({{ $permission->id }})" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">No permissions found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div>
        {{ $permissions->links() }}
    </div>
</div>

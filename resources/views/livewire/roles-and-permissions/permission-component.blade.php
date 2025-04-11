<div>
    <h2>Permissions</h2>

    @if (session()->has('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <input type="text" wire:model="search" placeholder="Search permissions...">

    <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
        <input type="text" wire:model="name" placeholder="Permission name">
        @error('name') <span class="text-danger">{{ $message }}</span> @enderror

        <button type="submit">{{ $isEditing ? 'Update' : 'Create' }}</button>
        @if ($isEditing)
            <button type="button" wire:click="resetInput">Cancel</button>
        @endif
    </form>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->name }}</td>
                    <td>
                        <button wire:click="edit({{ $permission->id }})">Edit</button>
                        <button wire:click="destroy({{ $permission->id }})" onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $permissions->links() }}
</div>

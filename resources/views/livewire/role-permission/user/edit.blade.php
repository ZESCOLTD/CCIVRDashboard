<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">

            @if ($errors->any())
                <ul class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Edit User
                        <a href="{{ url('users') }}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="update">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" wire:model="name" class="form-control" />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" wire:model="email" readonly class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label>Man No.</label>
                            <input type="text" wire:model="man_no" readonly class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" wire:model="password" class="form-control" />
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Separate div for Current Roles --}}
                        <div class="mb-3">
                            <label>Current Roles</label>
                            <div class="border p-2 bg-light rounded">
                                @forelse ($roles as $role) {{-- Using $roles directly from the component --}}
                                    <span class="badge bg-primary me-1">{{ $role }}</span>
                                @empty
                                    <span class="text-muted">No roles assigned.</span>
                                @endforelse
                            </div>
                        </div>

                        {{-- Multiple Select for Editing Roles --}}
                        <div class="mb-3">
                            <label>Update Roles</label>
                            <select wire:model="roles" multiple class="form-control">
                                {{-- <option value="">Select Role</option> This option is typically not useful for multiple selects --}}
                                @foreach ($allRoles as $role)
                                    {{-- The 'selected' attribute is handled by wire:model for multiple selects,
                                        but explicit check can sometimes improve initial rendering or fallback --}}
                                    <option value="{{ $role }}" {{ in_array($role, $roles) ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @endforeach
                            </select>

                            @error('roles')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
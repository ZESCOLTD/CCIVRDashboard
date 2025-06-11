<div>
    <div class="col-md-12">
        {{-- Custom Flash Messages --}}
        @if (session()->has('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ session('success') }}</p>
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        {{-- Info message for search results --}}
        @if (session()->has('info'))
            <div class="alert alert-info alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ session('info') }}</p>
            </div>
        @endif
    </div>

    <div class="card p-0">
        <div class="card-body">
            {{-- Laravel Validation Errors (from controller if any, though Livewire handles most) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" wire:submit.prevent="submit" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        {{-- Staff Number Search Input --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff_number_search_input">Search Staff Number / Name:</label>
                                <input type="text" id="staff_number_search_input"
                                    wire:model.live.debounce.300ms="StaffNumber" class="form-control"
                                    placeholder="Type staff number or name to search..." autocomplete="off" />
                                @error('StaffNumber')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Select Employee Dropdown for Search Results --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phris_employee_select">Select Employee:</label>
                                {{-- Removed 'select2' class --}}
                                <select id="phris_employee_select" wire:model.live="selectedEmployee"
                                    class="form-control"
                                    size="{{ count($phrisSearchResults) > 0 ? (count($phrisSearchResults) > 9 ? 10 : count($phrisSearchResults) + 1) : 1 }}">
                                    <option value="">-- Select a PHRIS Employee --</option>
                                    @foreach ($phrisSearchResults as $phrisUser)
                                        <option wire:key="phris-{{ $phrisUser->con_per_no }}" value="{{ $phrisUser->con_per_no }}">
                                            {{ $phrisUser->con_per_no }} - {{ $phrisUser->name }}
                                            ({{ $phrisUser->job_title }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedEmployee')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Form Fields (Autofilled from PHRIS, some can be disabled/readonly) --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff_email">Staff Email</label>
                                <input wire:model="StaffEmail" type="email" id="staff_email"
                                    class="form-control" placeholder="Auto-filled from PHRIS" readonly />
                                @error('StaffEmail')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name_field">Full Name</label>
                                <input wire:model="name" type="text" id="name_field" class="form-control"
                                    placeholder="Auto-filled from PHRIS" readonly />
                                @error('name')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee_grade">Employee Grade</label>
                                <input wire:model="EmployeeGrade" type="text" id="employee_grade"
                                    class="form-control" placeholder="Auto-filled from PHRIS" readonly />
                                @error('EmployeeGrade')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input wire:model="Department" type="text" id="department" class="form-control"
                                    placeholder="Auto-filled from PHRIS" readonly />
                                @error('Department')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input wire:model="Position" type="text" id="position" class="form-control"
                                    placeholder="Auto-filled from PHRIS" readonly />
                                @error('Position')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="staff_number_display">Staff Number</label>
                                <input wire:model="StaffNumber" type="text" id="staff_number_display"
                                    class="form-control" readonly />
                                @error('StaffNumber')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="division">Division</label>
                                <input wire:model="Division" type="text" id="division" class="form-control"
                                    placeholder="Auto-filled from PHRIS" readonly />
                                @error('Division')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="directorate">Directorate</label>
                                <input wire:model="Directorate" type="text" id="directorate" class="form-control"
                                    placeholder="Auto-filled from PHRIS" readonly />
                                @error('Directorate')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_field">Password</label>
                                <input wire:model="password" type="password" id="password_field"
                                    class="form-control" placeholder="Enter password for the new user" />
                                @error('password')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Livewire Loading Indicator --}}
                    <div wire:loading wire:target="StaffNumber, selectedEmployee, submit">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        Loading, please wait...
                    </div>

                    <button wire:loading.attr="disabled" type="submit" class="btn text-uppercase btn-success mt-4">
                        {{ isset($user) && $user->exists ? 'Update User' : 'Create User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
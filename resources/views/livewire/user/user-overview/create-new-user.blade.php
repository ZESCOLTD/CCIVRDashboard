<div>
    <div class="col-md-12">

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ $message }}</p>
            </div>
        @elseif($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>

    <div class="card p-0">
        <div class="card-body">
            {{--    <div class="card-body p-0">--}}

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

            <form method="POST" wire:submit.prevent="submit"
                  enctype="multipart/form-data"
            >
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div wire:ignore>
                                    <label>Select Employee</label>
                                    <select
                                        wire:model.defer=""
                                        class="form-control select2"
                                        id="dynamic-select-1"
                                    >
                                    </select>

                                    @error('')
                                    <span class="error text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Staff Email</label>

                                <input
                                    wire:model="StaffEmail"
                                    type="text"
                                    class="form-control"
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Employee Grade</label>

                                <input
                                    wire:model="EmployeeGrade"
                                    type="text"
                                    class="form-control"
                                    disabled
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Department</label>

                                <input
                                    wire:model="Department"
                                    type="text"
                                    class="form-control"
                                    disabled
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div wire:ignore>
                                    <label>Position</label>
                                    <input
                                        wire:model.defer="Position"
                                        class="form-control select2"
                                        id="dynamic-select"
                                        disabled
                                    />

                                    @error('')
                                    <span class="error text-red">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Staff Number</label>

                                <input
                                    wire:model="StaffNumber"
                                    type="text"
                                    class="form-control"
                                    disabled
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Division</label>

                                <input
                                    wire:model="Division"
                                    type="text"
                                    class="form-control"
                                    disabled
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Directorate</label>

                                <input
                                    wire:model="Directorate"
                                    type="text"
                                    class="form-control"
                                    disabled
                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Password</label>

                                <input
                                    wire:model="password"
                                    type="password"
                                    class="form-control"

                                    required

                                />

                                @error('')
                                <span class="error text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div wire:loading>
                        Loading, please wait
                    </div>
                    <button wire:loading.remove type="submit" class="btn text-uppercase btn-success">Submit
                    </button>

                </div>
            </form>
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            document.addEventListener("livewire:load", () => {
                let el = $('#dynamic-select-1')
                initSelect()

                Livewire.hook('message.processed', (message, component) => {
                    initSelect()
                })

                Livewire.on('setDynamicSelected', values => {
                    // el.val(values).trigger('change.select2');

                })

                el.on('change', function (e) {
                    @this.
                    set('selectedEmployee', el.select2("val"))
                })

                function initSelect() {
                    el.select2({
                        theme: 'bootstrap4',
                        placeholder: '{{__('Select your option')}}',
                        allowClear: true,

                        ajax: {
                            url: "{{route('getManNumbersFiltered')}}",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    _token: CSRF_TOKEN,
                                    search: params.term || "",
                                    page: params.page || 1
                                };
                            },
                        },
                        cache: true,
                    })
                }
            })
        </script>
    @endpush
</div>



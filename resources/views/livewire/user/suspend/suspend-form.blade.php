<div>

    <div class="row">
        <div class="col-md-12">

            @if ($message = Session::get('message'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="card">
                <div class="card-header">

                    <a class="btn btn-outline-success float-right"
                       href="{{ route('suspend.index') }}">
                        <i class="fa fa-backward"></i> Back
                    </a>

                </div>

            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <!-- /.col -->
        <div class="col-md-6">
            <div class="card">

                <div class="card-body p-0">

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

                    <form wire:submit.prevent="submit" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Suspend Until</label>
                                        <input
                                            wire:model="selectedDate"
                                            type="date"
                                            class="form-control"
                                            min="{{now()->toDateString()}}"
                                        />

                                        @error('selectedDate')
                                        <span class="error text-red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>

                        <div class="modal-footer">

                            <a href="{{ route('suspend.index') }}"
                               class="btn btn-outline-secondary">Cancel</a>

                            <div wire:loading>
                                Loading, please wait...
                            </div>
                            <button wire:loading.remove type="submit" class="btn btn-outline-success">
                                Submit
                            </button>

                        </div>
                    </form>


                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>

</div><!-- /.container-fluid -->

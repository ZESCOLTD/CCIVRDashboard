<div class="row">
    <div class="col-md-12">

        @if ($message = Session::get('message'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <p>{{ $message }}</p>
            </div>
        @endif


        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <div class="input-group-prepend float-right">
                    <button type="button"
                            class="btn btn-outline-success dropdown-toggle"
                            data-toggle="dropdown">Action <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu">
                        {{--                        <a class="dropdown-item" href="{{ route('un-suspend.index') }}">View Active</a>--}}
                        <a class="dropdown-item" href="{{ route('suspend.all.create') }}">Block All</a>
                        <a class="dropdown-item" href="#" wire:click.prevent="unSuspendAll">Un-Block All</a>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

        </div>
        <!-- /.card -->


        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-3">
                        <label>Search Term</label>
                        <div class="input-group">
                            <input wire:model.debounce.500ms="searchTerm"
                                   type="search"
                                   class="form-control"
                                   placeholder="Search by name or man number or NRC"
                            >
                            <div class="input-group-append">
                                <span wire:loading class="input-group-text">
                                    <i class="fas fa-1x fa-sync-alt fa-spin"></i>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-3">
                        <label>Is Blocked</label>
                        <div class="input-group">
                            <select wire:model="isBlocked"
                                    class="form-control"
                            >
                                <option value="1" >Yes</option>
                                <option value="0" >No</option>
                            </select>
                            <div class="input-group-append">
                            <span wire:loading class="input-group-text">
                                <i class="fas fa-1x fa-sync-alt fa-spin"></i>
                            </span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body table-responsive">
                <table class="table table-head-fixed table-hover table-striped table-bordered">
                    <thead>
                    <tr class="text-nowrap text-uppercase">
                        <th>MAN NO</th>
                        <th>NAME</th>
                        <th>GENDER</th>
                        <th>LOCATION</th>
                        <th>FUNCTIONAL SECTION</th>
                        <th>POSITION</th>
                        <th>GRADE</th>
                        <th>Block Until</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($dataset as $item)
                        <tr>
                            <td class="text-left">{{$item->man_no ?? "----" }}</td>
                            <td class="text-left">{{$item->name ?? "----" }}</td>
                            <td class="text-left">{{$item->gender ?? "----" }}</td>
                            <td class="text-left">{{$item->location ?? "----" }}</td>
                            <td class="text-left">{{$item->functional_section ?? "----" }}</td>
                            <td class="text-left">{{$item->job_title ?? "----" }}</td>
                            <td class="text-left">{{$item->grade ?? "----"}}</td>
                            <td class="text-left">{{!is_null($item->banned_until) ? date("l jS F Y", strtotime($item->banned_until)): ""}}</td>
                            <td class="text-center">
                                <div class="input-group-prepend">
                                    <button type="button"
                                            class="btn btn-outline-success dropdown-toggle"
                                            data-toggle="dropdown">Action <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{route('suspend.one.create',$item)}}">Block</a>
                                        @if(!is_null($item->banned_until))
                                            {{--                                            <a class="dropdown-item" href="#" wire:click.prevent="unSuspendOne({{$item}})">Un-Block</a>--}}
                                            <a class="dropdown-item" href="{{route('un-suspend.one.create',$item)}}" >Un-Block</a>
                                        @endif

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center text-red"><strong>No data found</strong></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

            <div class="card-footer clearfix">
                {{ $dataset ? $dataset->links():null }}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

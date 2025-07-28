<div class="card" >
{{--    wire:poll.5000ms--}}
    <div class="card-header border-0">
        <h3 class="card-title">Top Selected Menu</h3>
{{--        <div class="card-tools">--}}
{{--            <a href="#" class="btn btn-tool btn-sm">--}}
{{--                <i class="fas fa-download"></i>--}}
{{--            </a>--}}
{{--            <a href="#" class="btn btn-tool btn-sm">--}}
{{--                <i class="fas fa-bars"></i>--}}
{{--            </a>--}}
{{--        </div>--}}
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
                <th>Menu</th>
                <th class="text-right">Sessions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sessions as $session)
                <tr>
                    <td>{{$session->menu->description}}</td>
                    <td class=" text-right">{{$session->count}}</td>
                </tr>
             @endforeach
            <tr>
                <td class="text-bold">Total</td>
                <td class="text-bold text-right">{{$sessions->pluck('count')->sum()}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

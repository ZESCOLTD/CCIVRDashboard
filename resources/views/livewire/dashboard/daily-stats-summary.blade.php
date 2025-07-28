<div class="card">
    {{--    wire:poll.5000ms--}}
    <div class="card-header border-0">
        <h3 class="card-title">Daily Stats Summary (Last 24 Hours)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
            <tr>
                <th>Network/Channel</th>
                <th class="text-right">Sessions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dailyStats as $item)
                <tr>
                    <td>{{$item->network}}</td>
                    <td class=" text-right">{{$item->sessions}}</td>
                </tr>
            @endforeach
            {{--            <tr>--}}
            {{--                <td class="text-bold">Total</td>--}}
            {{--                <td class="text-bold text-right">{{$sessions->pluck('count')->sum()}}</td>--}}
            {{--            </tr>--}}
            </tbody>
        </table>
    </div>
</div>

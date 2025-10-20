<div class="container">

    <h1>Call Statistics</h1>

    {{-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>Type</th>
                <th>Caller Number</th>
                <th>Callee Extension</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($answered as $call)
                <tr>
                    <td>Answered</td>
                    <td>{{ $call->caller_number }}</td>
                    <td>{{ $call->callee_extension }}</td>
                    <td>{{ $call->call_time }}</td>
                </tr>
            @endforeach

            @foreach ($missed as $call)
                <tr>
                    <td>Missed</td>
                    <td>{{ $call->caller_number }}</td>
                    <td>-</td>
                    <td>{{ $call->call_time }}</td>
                </tr>
            @endforeach

            @foreach ($abandoned as $call)
                <tr>
                    <td>Abandoned</td>
                    <td>{{ $call->caller_number }}</td>
                    <td>-</td>
                    <td>{{ $call->call_time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
    <h1 class="mb-4">Stasis Start Events</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Type</th>
                <th>Timestamp</th>
                <th>Stasis End Timestamp</th>
                <th>Asterisk ID</th>
                <th>Application</th>
                <th>Channel ID</th>
                <th>Channel Name</th>
                <th>Channel State</th>
                <th>Caller Name</th>
                <th>Caller Number</th>
                <th>Connected Name</th>
                <th>Connected Number</th>
                <th>Dialplan Context</th>
                <th>Dialplan Extension</th>
                <th>Dialplan Priority</th>
                <th>Channel Creation Time</th>
                <th>Channel Language</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stasisEndEventLog as $event)
                <tr>
                    <td>{{ $event->type }}</td>
                    <td>{{ $event->timestamp->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $event->stasisEnd ? $event->stasisEnd->timestamp->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    {{-- <td>{{ $event->stasis_end_timestamp }}</td> --}}
                    <td>{{ $event->asterisk_id }}</td>
                    <td>{{ $event->application }}</td>
                    <td>{{ $event->channel_id }}</td>
                    <td>{{ $event->channel_name }}</td>
                    <td>{{ $event->channel_state }}</td>
                    <td>{{ $event->caller_name }}</td>
                    <td>{{ $event->caller_number }}</td>
                    <td>{{ $event->connected_name }}</td>
                    <td>{{ $event->connected_number }}</td>
                    <td>{{ $event->dialplan_context }}</td>
                    <td>{{ $event->dialplan_exten }}</td>
                    <td>{{ $event->dialplan_priority }}</td>
                    <td>{{ $event->channel_creationtime->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $event->channel_language }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{-- {{ $stasisEndEventLog->links() }} --}}
    </div>
</div>

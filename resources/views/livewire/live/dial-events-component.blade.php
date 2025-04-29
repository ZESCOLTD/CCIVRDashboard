<div class="container">
    <h2>Dial Event Logs</h2>
    <table class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event Type</th>
                <th>Event Timestamp</th>
                <th>Dialstatus</th>
                <th>Forward</th>
                <th>Dialstring</th>
                <th>Asterisk ID</th>
                <th>Application</th>
                <th>Peer ID</th>
                <th>Peer Name</th>
                <th>Peer State</th>
                <th>Peer Protocol ID</th>
                <th>Peer Accountcode</th>
                <th>Peer Creation Time</th>
                <th>Peer Language</th>
                <th>Caller Name</th>
                <th>Caller Number</th>
                <th>Connected Name</th>
                <th>Connected Number</th>
                <th>Dialplan Context</th>
                <th>Dialplan Exten</th>
                <th>Dialplan Priority</th>
                <th>Dialplan App Name</th>
                <th>Dialplan App Data</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dialEventLog as $log)
                <tr>
                    <td>{{ $log->id }}</td>
                    <td>{{ $log->event_type }}</td>
                    <td>{{ $log->event_timestamp->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $log->dialstatus }}</td>
                    <td>{{ $log->forward }}</td>
                    <td>{{ $log->dialstring }}</td>
                    <td>{{ $log->asterisk_id }}</td>
                    <td>{{ $log->application }}</td>
                    <td>{{ $log->peer_id }}</td>
                    <td>{{ $log->peer_name }}</td>
                    <td>{{ $log->peer_state }}</td>
                    <td>{{ $log->peer_protocol_id }}</td>
                    <td>{{ $log->peer_accountcode }}</td>
                    <td>{{ $log->peer_creationtime->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $log->peer_language }}</td>
                    <td>{{ $log->caller_name }}</td>
                    <td>{{ $log->caller_number }}</td>
                    <td>{{ $log->connected_name }}</td>
                    <td>{{ $log->connected_number }}</td>
                    <td>{{ $log->dialplan_context }}</td>
                    <td>{{ $log->dialplan_exten }}</td>
                    <td>{{ $log->dialplan_priority }}</td>
                    <td>{{ $log->dialplan_app_name }}</td>
                    <td>{{ $log->dialplan_app_data }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="24">No dial events found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $dialEventLog->links() }}
    </div>
</div>

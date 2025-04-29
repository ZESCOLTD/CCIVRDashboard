<div class="container">
    <h1 class="mb-4">Stasis End Events</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Type</th>
                    <th>Timestamp</th>
                    <th>Asterisk ID</th>
                    <th>Application</th>
                    <th>Channel ID</th>
                    <th>Channel Name</th>
                    <th>Channel State</th>
                    <th>Channel Protocol ID</th>
                    <th>Caller Name</th>
                    <th>Caller Number</th>
                    <th>Connected Name</th>
                    <th>Connected Number</th>
                    <th>Accountcode</th>
                    <th>Dialplan Context</th>
                    <th>Dialplan Exten</th>
                    <th>Dialplan Priority</th>
                    <th>Dialplan App Name</th>
                    <th>Dialplan App Data</th>
                    <th>Channel Creation Time</th>
                    <th>Channel Language</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stasisEndEventLog as $event)
                <tr>
                    <td>{{ $event->type }}</td>
                    <td>{{ $event->timestamp }}</td>
                    <td>{{ $event->asterisk_id }}</td>
                    <td>{{ $event->application }}</td>
                    <td>{{ $event->channel_id }}</td>
                    <td>{{ $event->channel_name }}</td>
                    <td>{{ $event->channel_state }}</td>
                    <td>{{ $event->channel_protocol_id }}</td>
                    <td>{{ $event->caller_name }}</td>
                    <td>{{ $event->caller_number }}</td>
                    <td>{{ $event->connected_name }}</td>
                    <td>{{ $event->connected_number }}</td>
                    <td>{{ $event->accountcode }}</td>
                    <td>{{ $event->dialplan_context }}</td>
                    <td>{{ $event->dialplan_exten }}</td>
                    <td>{{ $event->dialplan_priority }}</td>
                    <td>{{ $event->dialplan_app_name }}</td>
                    <td>{{ $event->dialplan_app_data }}</td>
                    <td>{{ $event->channel_creationtime }}</td>
                    <td>{{ $event->channel_language }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
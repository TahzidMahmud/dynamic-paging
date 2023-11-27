<table>
    <thead>
        <tr>
            <th>User</th>
            <th >Action</th>
            <th >User Type</th>
            <th >User New Type</th>
            <th >Performed By</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $log)

        <tr>
            @if($log->user_name == null)
                <td>{{ $log->user->name ?? 'Deleted User' }}</td>
            @else
                <td>{{ $log->user_name ?? 'Deleted User'}}</td>
            @endif
            <td>{{ $log->action }}</td>
            @if($log->user_type)
                <td>{{ $log->user_type ?? $log->user->type }}</td>
            @endif
            @if($log->user_new_type)
                <td>{{ $log->user_new_type ?? $log->user->type }}</td>
            @endif
            @if($log->performed_by_name)
                <td>{{ $log->performed_by_name }}</td>
            @elseif($log->performed_by_name == 0)
                <td>{{ 'System' }}</td>
            @elseif($log->performed_by_name == null)
            <td>{{ 'System' }}</td>
            @else
                <td>{{ 'Deleted User' }}</td>
            @endif
            <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

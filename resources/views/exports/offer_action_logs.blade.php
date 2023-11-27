<table>
    <thead>
        <tr>

            <th>Offer</th>
            <th>Action</th>
            <th >Performed By</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $log)

        @php
            $user=$log->user;
            $role=$log->role;
        @endphp
            <tr>
                @if($log->offer_name)
                    <td>{{ $log->offer_name }}</td>
                @elseif($log->offer_id)
                    <td>{{ $log->offer_id->title }}</td>
                @else
                    <td>{{ 'Deleted Product' }}</td>
                @endif
                    <td>{{ $log->action }}</td>
                @if($log->user_name)
                    <td>{{ $log->user_name }}</td>
                @elseif($user)
                    <td>{{ $user->name }}</td>
                @else
                    <td>Data Not Found</td>
                @endif
                <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

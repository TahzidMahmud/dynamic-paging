<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>
            <th>Order-Code</th>
            <th>Old Status</th>
            <th>Updated Status</th>
            <th>User</th>
            <td>Contact</td>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $log)
            @php
                $order=$log->order;
                $user=$log->user;
            @endphp
            <tr>
                @if($order)
                <td><a href="{{ route('orders.show',encrypt($order->id)) }}">{{ $order->combined_order->code }}</a></td>
               @else
                <td>{{ $log->order_code }}</td>
               @endif
                <td>{{ $log->old_stat }}</td>
                <td>{{ $log->new_stat }}</td>
                @if ($log->user_name)
                <td>{{ $log->user_name }}</td>
                @elseif ($log->user->name)
                <td>{{ $log->user->name }}</td>
                @else
                <td>{{ 'Deleted User' }}</td>
                @endif

                @if ($log->user)
                    @if($log->user->email)
                    <td>{{ $log->user->email ?? 'Deleted User'}}</td>
                    @elseif($log->user->phone)
                    <td>{{ $log->user->phone }}</td>
                    @else
                    <td>{{ 'Deleted User' }}</td>
                    @endif
                @else
                    <td>{{ 'Deleted User' }}</td>
                @endif

                <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

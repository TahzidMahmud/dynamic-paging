<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>
            <th>Product</th>
            <th >Action</th>
            <th >Data Change</th>
            <th >User</th>
            <td>Contact</td>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $log)

        <tr>
            @if($log->product_name == null)
                <td>{{ $log->product->name ?? 'Deleted User' }}</td>
            @else
                <td>{{ $log->product_name ?? 'Deleted Product'}}</td>
            @endif
                <td>{{ $log->action }}</td>
            @if($log->data_change)
                <td>
                    @if(property_exists(json_decode($log->data_change),'name'))
                        {{'Name - '}}{{ json_decode($log->data_change)->name }}<br>
                    @endif
                    @if(property_exists(json_decode($log->data_change),'price'))
                         {{'Price - '}}{{ json_decode($log->data_change)->price }}<br>
                    @endif
                    @if(property_exists(json_decode($log->data_change),'stock'))
                         {{'Stock - '}}{{ json_decode($log->data_change)->stock }}<br>
                    @endif
                    @if(property_exists(json_decode($log->data_change),'discount'))
                        {{'Discount - '}}{{ json_decode($log->data_change)->discount }} @if(property_exists(json_decode($log->data_change),'discount_type'))({{ json_decode($log->data_change)->discount_type }})@else {{ $log->product->discount_type}}@endif<br>
                    @endif

                    @if(property_exists(json_decode($log->data_change),'description'))
                         {{'Description - Updated'}}<br>
                    @endif

                </td>
            @else
            <td></td>
            @endif

            @if($log->user_name)
                <td>{{ $log->user_name ?? 'Deleted User' }}</td>
            @elseif($log->user_id)
                <td>{{ $log->user->name ?? 'Deleted User' }}</td>
            @elseif($log->guest_id)

                @php
                    $temp_user = App\Models\CombinedOrder::where('user_id',$log->guest_id)->first();

                    $order = App\Models\Order::where('combined_order_id',$temp_user->id)->first();
                @endphp
                @if($order)
                <td>{{ 'Guest('.$order->guest_id.')' ?? 'Deleted User' }}</td>
                @else
                <td>{{ 'Guest('.$log->guest_id.')' ?? 'Deleted User' }}</td>
                @endif
            @else
                <td>{{ 'Deleted User' }}</td>
            @endif
            @if($log->user->email ?? null)
                <td>{{ $log->user->email ?? 'Deleted User' }}</td>
            @elseif($log->user->phone ?? null)
                <td>{{ $log->user->phone ?? 'Deleted User' }}</td>
            @elseif($log->guest_id ?? null)
                @if($order)
                <td>{{ 'Guest('.$order->guest_id.')' ?? 'Deleted User' }}</td>
                @else
                <td>{{ 'Guest('.$log->guest_id.')' ?? 'Deleted User' }}</td>
                @endif
            @else
                <td>{{ 'Deleted User' }}</td>
            @endif
            <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

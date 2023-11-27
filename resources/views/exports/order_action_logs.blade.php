<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>
            <th>Order-Code</th>
            <th>Sold From</th>
            <th>Action Performed</th>
            <th>Change</th>
            <th>Performed By</th>
            <th>Contact</th>
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
                <td>{{ $log->type }}</td>
                <td>{{ $log->action }}</td>

                @if($log->data_change)
                    <td>
                        @if(property_exists(json_decode($log->data_change),'shipping_cost') && property_exists(json_decode($log->data_change),'discount'))
                            {{'Shipping Cost - '}}{{ json_decode($log->data_change)->shipping_cost }}<br>
                        @endif
                        @if(property_exists(json_decode($log->data_change),'discount'))
                             {{'Discount - '}}{{ json_decode($log->data_change)->discount }}<br>
                        @endif
                        @if(property_exists(json_decode($log->data_change),'advance_payment'))
                            {{'Advance Payment - '}}{{ json_decode($log->data_change)->advance_payment }}<br>
                        @endif
                        @if(property_exists(json_decode($log->data_change),'new_added') )
                            @php
                                $new_added = json_decode($log->data_change)->new_added;
                            @endphp

                            @foreach($new_added as $key => $val)
                            {{'Newly Added = '}}<br>
                            {{'Product - '}}{{$val->product_name}}<br>
                            @if(array_key_exists("product_variation_id",$val))
                                @php
                                        $name = '';
                                        $variation = \App\Models\ProductVariation::where('id',$val->product_variation_id)->first();
                                        $code_array = array_filter(explode('/', $variation->code));
                                        $lstKey = array_key_last($code_array);

                                        foreach ($code_array as $j => $comb) {
                                            $comb = explode(':', $comb);

                                            $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                                            $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                                            $name .= $option_name . ': ' . $choice_name;

                                            if ($lstKey != $j) {
                                                $name .= ' / ';
                                            }
                                        }
                                    @endphp
                                {{'Variation - '}}{{$name}}<br>
                            @endif
                                {{'Quantity - '}}{{$val->product_quantity ?? ""}}<br>
                            @endforeach
                        @endif
                        @if(property_exists(json_decode($log->data_change),'deleted') )
                            @php
                                $deleted = json_decode($log->data_change)->deleted;
                            @endphp

                            @foreach($deleted as $key => $val)
                            {{'Deleted = '}}<br>
                            {{'Product - '}}{{$val->product_name}}<br>
                            @if(array_key_exists("product_variation_id",$val))
                                @php
                                    $name = '';
                                    $variation = \App\Models\ProductVariation::where('id',$val->product_variation_id)->first();
                                    $code_array = array_filter(explode('/', $variation->code));
                                    $lstKey = array_key_last($code_array);

                                    foreach ($code_array as $j => $comb) {
                                        $comb = explode(':', $comb);

                                        $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                                        $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                                        $name .= $option_name . ': ' . $choice_name;

                                        if ($lstKey != $j) {
                                            $name .= ' / ';
                                        }
                                    }
                                @endphp
                            {{'Variation - '}}{{$name}}<br>
                            @endif

                                {{'Quantity - '}}{{$val->product_quantity ?? ""}}<br>
                            @endforeach
                        @endif
                        @if(property_exists(json_decode($log->data_change),'updated'))
                            @php
                                $update_data = json_decode($log->data_change)->updated;
                            @endphp

                            @foreach($update_data as $key => $val)
                            {{'Updated = '}}<br>
                            {{'Product - '}}{{$val->product_name}}<br>
                            @if(array_key_exists("product_variation_id",$val))
                                @php
                                    $name = '';
                                    $variation = \App\Models\ProductVariation::where('id',$val->product_variation_id)->first();
                                    $code_array = array_filter(explode('/', $variation->code));
                                    $lstKey = array_key_last($code_array);

                                    foreach ($code_array as $j => $comb) {
                                        $comb = explode(':', $comb);

                                        $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                                        $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                                        $name .= $option_name . ': ' . $choice_name;

                                        if ($lstKey != $j) {
                                            $name .= ' / ';
                                        }
                                    }
                                @endphp
                                {{'Variation - '}}{{$name}}<br>
                            @endif
                                {{'Quantity - '}}{{$val->product_quantity  ?? ""}}<br>
                            @endforeach
                        @endif

                    </td>
                @else
                <td></td>
                @endif

                @if ($log->user_name)
                    <td>{{ $log->user_name }}</td>
                @elseif ($user)
                    <td>{{ $user->name }}</td>
                @elseif ($log->guest_id)
                    @php
                    $temp_user = App\Models\CombinedOrder::where('user_id',$log->guest_id)->first();
                    if($temp_user){

                        $order = App\Models\Order::where('combined_order_id',$temp_user->id)->first();
                    }
                    @endphp
                    @if($order)
                    <td>{{ 'Guest('.$order->guest_id.')' ?? 'Deleted User' }}</td>
                    @else
                    <td>{{ 'Guest('.$log->guest_id.')' ?? 'Deleted User' }}</td>
                    @endif
                @else
                    <td>{{ 'Deleted User' }}</td>

                @endif
               @if($user)
                    @if($user->email)
                        <td>{{ $user->email }}</td>
                    @elseif($user->phone)
                        <td>{{ $user->phone }}</td>

                    @else
                        <td>{{ 'Data not found' }}</td>
                    @endif
                @elseif ($log->guest_id)
                    @php
                    $temp_user = App\Models\CombinedOrder::where('user_id',$log->guest_id)->first();

                    if($temp_user){

                        $order = App\Models\Order::where('combined_order_id',$temp_user->id)->first();
                    }
                    @endphp
                    @if($order)
                        @if(json_decode($order->billing_address)->phone)
                        <td>{{ trim(json_decode($order->billing_address)->phone,"+88") }}</td>
                        @elseif(property_exists(json_decode($order->billing_address),'email'))
                        <td>{{ json_decode($order->billing_address)->email }}</td>
                        @else
                        <td>{{ 'Data Not Found' }}</td>
                        @endif
                        @else
                        <td>{{ 'Data Not Found' }}</td>
                    @endif
                @else
                    <td>{{ 'Data not found' }}</td>
               @endif
                <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

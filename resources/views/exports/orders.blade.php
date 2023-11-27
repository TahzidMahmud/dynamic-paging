<table>
    <thead>
        <tr>
            <th>Order Code</th>
            <th>Product</th>
            <th>Variant</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Customer Address</th>
            <th>Order Date</th>
            <th>Order Status</th>
            <th>Tax</th>
            <th>Shipping Cost</th>
            <th>Profit</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)

            @foreach ($order->orderDetails as $orderDetail)
                <tr>
                        <td>{{ $order->combined_order->code }}</td>
                       @if ($orderDetail)

                            @if ($orderDetail->product != null)
                               <td> {{ $orderDetail->product->name }} </td>
                            @else
                                <td>{{ 'Data Not Found' }}</td>
                            @endif

                            <td>
                                @php
                                    $variant = '';
                                    if(isset($orderDetail->variation['code'])){

                                        $code_array = array_filter(explode('/', $orderDetail->variation->code));
                                        $lstKey = array_key_last($code_array);

                                        foreach ($code_array as $j => $comb) {
                                            $comb = explode(':', $comb);

                                            $option_name = \App\Models\Attribute::find($comb[0])->getTranslation('name');
                                            $choice_name = \App\Models\AttributeValue::find($comb[1])->getTranslation('name');

                                            $variant .= $option_name . ': ' . $choice_name;

                                            if ($lstKey != $j) {
                                                $variant .= ' / ';
                                            }
                                        }
                                    }
                                @endphp
                                    {{ $variant }}
                                
                            </td>
                            <td>{{ $orderDetail->quantity }}</td>
                            <td>{{ $orderDetail->price }}</td>
                            
                            <td>
                                @if(property_exists(json_decode($orderDetail->order->shipping_address),'name'))
                                    {{ json_decode($orderDetail->order->shipping_address)->name ? json_decode($orderDetail->order->shipping_address)->name : ($orderDetail->order->user ? $orderDetail->order->user->name : 'Deleted User') }}

                                @elseif ($order->user != null)
                                    {{ $order->user->name }}
                                @elseif ($orderDetail->order->guest_id)
                                    Guest ({{ $orderDetail->order->guest_id }})

                                @else
                                    {{ 'User Not Found' }}
                                @endif
                            </td>

                            <td>
                                @if($orderDetail->order->user)

                                    @if($orderDetail->order->user->phone)
                                        {{trim($orderDetail->order->user->phone,"+88") }}

                                    @elseif(json_decode($orderDetail->order->shipping_address))
                                        @if(property_exists(json_decode($orderDetail->order->shipping_address),'phone'))
                                            {{ trim(json_decode($orderDetail->order->shipping_address)->phone, "+88") }}
                                        @endif


                                    @else
                                        {{ '' }}
                                    @endif
                                @elseif ($orderDetail->order->guest_id)
                                    @if(property_exists(json_decode($orderDetail->order->shipping_address),'phone'))
                                        {{ json_decode($orderDetail->order->shipping_address) ? trim(json_decode($orderDetail->order->shipping_address)->phone,"+88") : 'Data Not Found' }}

                                    @else
                                        {{ '' }}
                                    @endif
                                @else
                                    {{ 'Data Not Found' }}
                                @endif

                            </td>

                            <td>
                                @if($orderDetail->order->user)
                                    @if($orderDetail->order->user->email)
                                        {{ $orderDetail->order->user->email }}

                                    @elseif(json_decode($orderDetail->order->shipping_address))
                                        @if(property_exists(json_decode($orderDetail->order->shipping_address),'email'))
                                            {{ json_decode($orderDetail->order->shipping_address)->email }}
                                        @endif


                                    @else
                                        {{ '' }}
                                    @endif
                                @elseif ($orderDetail->order->guest_id)

                                    @if(property_exists(json_decode($orderDetail->order->shipping_address),'email'))
                                        {{ json_decode($orderDetail->order->shipping_address) ? json_decode($orderDetail->order->shipping_address)->email : 'Data Not Found' }}
                                    @else
                                        {{ '' }}
                                    @endif
                                @else
                                    {{ 'Data Not Found' }}
                                @endif
                            </td>

                            <td>{{ json_decode($orderDetail->order->shipping_address)->address ?? 'Data Not Found' }}</td>
                            <td>{{Carbon\Carbon::parse($orderDetail->created_at)->format('d-m-Y') }}</td>
                            <td>{{ $order->delivery_status }}</td>
                            <td>{{ $orderDetail->tax }}</td>
                            <td>{{ $order->shipping_cost }}</td>
                            <td>{{ $orderDetail->profit }}</td>
                       @else
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>

                       @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

@php
	$font_family = "'Hind Siliguri','sans-serif'";
	$direction = 'ltr';
	$text_align = 'left';
    $not_text_align = 'right';
@endphp
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/aiz-core.css') }}">


    </head>
<body>
	<div>

		@php
			$logo = get_setting('header_logo');
		@endphp

		<div style="background: #eceff4;padding: 1rem;">
			<table>
				<tr>
					<td>
						@if($logo != null)
							<img src="{{ uploaded_asset($logo) }}" height="30" style="display:inline-block;">
						@else
							<img src="{{ asset('assets/img/logo.png') }}" height="30" style="display:inline-block;">
						@endif
					</td>
					<td style="font-size: 1.5rem;" class="text-right strong">{{  translate('Sales Report') }}</td>
				</tr>
			</table>
			<table>
				<tr>
					<td style="font-size: 1rem;" class="strong">{{ get_setting('site_name') }}</td>
					<td class="text-right"></td>
				</tr>
				<tr>
					<td class="gry-color small">{{ get_setting('contact_address') }}</td>
					<td class="text-right"></td>
				</tr>

			</table>

		</div>


	    <div style="padding: 1rem;">

            <table class="table">
                <thead class="thead-light padding text-left small border-bottom">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Order Code</th>
                    <th scope="col">Product</th>
                    <th scope="col">Variant</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Tax</th>
                    <th scope="col">Shipping</th>
                    <th scope="col">Profit</th>

                  </tr>
                </thead>
                <tbody class="strong">
                    @foreach ($orders as $key=>$order)

                        @foreach ($order->orderDetails as $orderDetail)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                    <td>{{ $order->code }}</td>
                                    <td>
                                        @if ($orderDetail->product != null)
                                            {{ $orderDetail->product->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $name = '';
                                            if(isset($orderDetail->variation['code'])){

                                                $code_array = array_filter(explode('/', $orderDetail->variation->code));
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
                                            }
                                        @endphp
                                            {{ $name }}

                                    </td>
                                    <td>{{ $orderDetail->quantity }}</td>
                                    <td>{{ $orderDetail->price }}</td>
                                    <td>{{ $orderDetail->tax }}</td>
                                    <td>{{ $order->shipping_cost }}</td>

                                    @if( $orderDetail->profit==null)
                                        <td>0</td>
                                    @else
                                        <td>{{ $orderDetail->profit }}</td>
                                    @endif
                                </tr>
                        @endforeach
                    @endforeach
                </tbody>
              </table>
		</div>

	    {{-- <div style="padding:0 1.5rem;">
	        <table class="text-right sm-padding small strong">
	        	<thead>
	        		<tr>
	        			<th width="60%"></th>
	        			<th width="40%"></th>
	        		</tr>
	        	</thead>
		        <tbody>
			        <tr>
			            <td>
			            </td>
			            <td>
					        <table class="text-right sm-padding small strong">
						        <tbody>
							        <tr>
							            <th class="gry-color text-left">{{ translate('Sub Total') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('price')) }}</td>
							        </tr>
							        <tr>
							            <th class="gry-color text-left">{{ translate('Shipping Cost') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('shipping_cost')) }}</td>
							        </tr>
							        <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Total Tax') }}</th>
							            <td class="currency">{{ single_price($order->orderDetails->sum('tax')) }}</td>
							        </tr>
				                    <tr class="border-bottom">
							            <th class="gry-color text-left">{{ translate('Coupon Discount') }}</th>
							            <td class="currency">{{ single_price($order->coupon_discount) }}</td>
							        </tr>
							        <tr>
							            <th class="text-left strong">{{ translate('Grand Total') }}</th>
							            <td class="currency">{{ single_price($order->grand_total) }}</td>
							        </tr>
							        <tr>
							            <th class="text-left strong">{{ translate('Due') }}</th>
							            <td class="currency">
							            	@if($order->payment_status == 'unpaid')
                                            	{{ single_price($order->grand_total) }}
                                            @else
                                            	{{ single_price(0) }}
                                            @endif
							            </td>
							        </tr>
						        </tbody>
						    </table>
			            </td>
			        </tr>
		        </tbody>
		    </table>
	    </div> --}}

	</div>

	<script type="text/javascript">
        try { this.print(); } catch (e) { window.onload = window.print; }
        window.onbeforeprint = function() {
            setTimeout(function(){
                window.close();
            }, 1500);
        }
    </script>
</body>
</html>

@extends('backend.layouts.app')

@section('content')

<div class="row">
	<div class="col-12 mx-auto">
		<div class="aiz-titlebar text-left mt-2 mb-3">
			<div class=" align-items-center">
		       <h1 class="h3">{{translate('Sale Stats')}}</h1>
			</div>
		</div>

		<div class="card">
			<div class="card-header">

				<div class="col">
					<form action="" method="GET">
						<div class="form-group row ">

							<div class="col-md-4">
								<div>
									<input type="text" class="aiz-date-range form-control" name="date" value="{{ $date }}" placeholder="Select Date" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-2">
								<button class="btn btn-light" type="submit">{{ translate('Filter') }}</button>
							</div>
                            @can('export_reports')
                                <div class="col-md-2">
                                    <button class="btn btn-light" type="submit" value="export" name="button">{{ translate('Export') }}</button>
                                </div>
                            @endcan
						</div>
					</form>
				</div>
			</div>
			<div class="card-body">
				<div class="row no-gutters border">
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ single_price($net) }}</h4>
							<div class="opacity-60">{{ translate('Net sales') }}</div>
						</div>
					</div>
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ single_price($profit) }}</h4>
							<div class="opacity-60">{{ translate('Net profit') }}</div>
						</div>
					</div>
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ $items }}</h4>
							<div class="opacity-60">{{ translate('Item purchased') }}</div>
						</div>
					</div>
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ $num_orders }}</h4>
							<div class="opacity-60">{{ translate('orders placed') }}</div>
						</div>
					</div>
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ single_price($tax) }}</h4>
							<div class="opacity-60">{{ translate('Total Tax') }}</div>
						</div>
					</div>
					<div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ single_price($shipping) }}</h4>
							<div class="opacity-60">{{ translate('Shipping cost') }}</div>
						</div>
					</div>
					{{-- <div class="com-sm-6 col-lg-4">
						<div class="border px-3 py-4">
							<h4 class="mb-0">{{ single_price($coupon) }}</h4>
							<div class="opacity-60">{{ translate('Coupon used') }}</div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>

    <div class="col-12">
        <div class="card">
           <div class="text-right">
            <a  href="javascript:void(0)" onclick="print_invoice('{{ route('sale_report.print') }}')" class="btn btn-soft-primary btn-icon btn-circle btn-lg my-2 mx-2"><i class="las la-print"></i></a>
           </div>
           <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
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
                        <tbody>
                            @foreach ($orders as $key=>$order)
                                @foreach ($order->orderDetails as $orderDetail)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                            <td>{{ $order->combined_order->code }}</td>
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
           </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript">
    function print_invoice(url){
        var current_url=window.location.href;
        var currenturlParam = current_url.split("?");
        var newUrl = `${url}?${currenturlParam[1]}`
         var h = $(window).height();
         var w = $(window).width();
         window.open( newUrl, '_blank', 'height='+h+',width='+w+',scrollbars=yes,status=no' );

     }
 </script>

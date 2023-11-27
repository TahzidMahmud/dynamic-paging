@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Offer Detail Report')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{route('offer_sales.show', $offer->id) }}" method="GET">
                    <div class="form-group row ">
                        <div class="col-md-10">
                            <h3>Offer: {{ $offer->title }}</h3>
                            <span>Started At: {{ date('d-m-Y H:i:s',$offer->start_date) }}</span>
                            <span class="mx-4">Ended At: {{ date('d-m-Y H:i:s',$offer->end_date) }}</span>
                        </div>

                        @can('export_activity_logs')
                            <div class="col-md-1">
                                <button class="btn btn-light" type="submit" value="export" name="button">{{ translate('Export') }}</button>
                            </div>
                        @endcan
                    </div>
                </form>

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Product</th>
                            <th>Sold Qty</th>
                            <th>Price</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $row)
                            <tr>
                                <td>{{ $row->order->combined_order->code }}</td>
                                <td>{{ $row->product->name }}</td>
                                <td>{{ $row->qty_sold }}</td>
                                <td>{{ $row->price }}</td>
                                <td>{{ $row->profit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection

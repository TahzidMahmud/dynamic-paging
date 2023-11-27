@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Offer Wise Sales Summary Report')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('offer_sales.index') }}" method="GET">
                        <label class="col-md-2 col-form-label">{{translate('Sort by Offer')}} :</label>
                    <div class="form-group row ">
                        <div class="col-md-10">

                            <select class="from-control aiz-selectpicker" name="offer_id" class="text-center" >
                              <option value="" class="text-center">--All --</option>

                              @foreach ($offers as $offer)

                                <option value="{{ $offer['id'] }}" @if( $offer['id'] == $offer_id) selected @endif class="text-center">{{ $offer['title'] }}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">{{ translate('Filter') }}</button>
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
                            <th>Offer Title</th>
                            <th>Started At</th>
                            <th>Ended At</th>
                            <th>Total Sold</th>
                            <th>Total Profit</th>
                            <th>Sold Products Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_array as $key => $sale)
                            <tr>
                                <td>{{ $sale['offer_title'] }}</td>
                                <td>{{ date('d-m-Y H:i:s',$sale['start_date']) }}</td>
                                <td>{{ date('d-m-Y H:i:s',$sale['end_date']) }}</td>
                                <td>{{ $sale['total_sales'] }}</td>
                                <td>{{ $sale['total_profit'] }}</td>
                                <td>{{ $sale['total_products_sold'] }}</td>
                                <td>
                                    @if($sale['status'] == 1)
                                        <span class="text-success">{{ translate('Active') }}</span>
                                    @else
                                        <span class="text-danger">{{ translate('Inactive') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('offer_sales.show', $sale['offer_id']) }}" class="btn btn-sm btn-primary">{{ translate('View') }}</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection

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

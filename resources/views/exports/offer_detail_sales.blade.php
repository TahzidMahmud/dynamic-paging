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

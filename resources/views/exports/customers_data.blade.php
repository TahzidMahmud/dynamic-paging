<table>
   <thead>
       <tr>
        <th>Customer</th>
        <th>Phone</th>
        <th>Email</th>
       </tr>
   </thead>
   <tbody>
        @foreach ($customers as $key=>$customer)


            @if($customer && $customer->email_verified_at != null)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone? trim($customer->phone,"+88"): "NO Data"}}</td>
                <td>{{ $customer->email?$customer->email: "No Data"}}</td>
            </tr>
            @endif
        @endforeach
   </tbody>
</table>

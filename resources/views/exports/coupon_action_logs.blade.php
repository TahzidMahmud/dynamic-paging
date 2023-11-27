<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>

            <th>{{ translate('Coupon') }}</th>
            <th>{{ translate('Action') }}</th>
            <th >{{ translate('Performed By') }}</th>
            <th>{{ translate('Date') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($logs as $key => $log)

        @php
            $user=$log->user;
            $role=$log->role;
        @endphp
            <tr>

               <td>{{ $log->coupon_code }}</td>
               <td>{{ $log->action }}</td>

               @if($user)
               <td>{{ $user->name }}</td>
                @else
                <td>Data Not Found</td>
               @endif
                <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

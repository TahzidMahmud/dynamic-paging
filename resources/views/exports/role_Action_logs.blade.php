<table class="table table-bordered aiz-table mb-0">
    <thead>
        <tr>
            <th >{{ translate('Role') }}</th>
            <th>{{ translate('Action') }}</th>
            <th>{{ translate('Permission Update') }}</th>
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
                @if ($log->role_name)
                    <td>{{ $log->role_name }}</td>
                @elseif ($role)
                    <td>{{ $role->name }}</td>
                @else
                    <td>{{ 'Data Not Found' }}</td>
                @endif

                <td>{{ $log->action }}</td>

                @if($log->permission_update)
                    <td>
                        @if(property_exists(json_decode($log->permission_update),'new_added') && count(json_decode($log->permission_update)->new_added) > 0)
                            @php
                                $new_added = json_decode($log->permission_update)->new_added;
                            @endphp

                            {{'Newly Added = '}}<br>
                            @foreach($new_added as $key => $val)
                                {{ucwords(str_replace('_', ' ', $val))}}<br>

                            @endforeach
                        @endif
                        @if(property_exists(json_decode($log->permission_update),'deleted') && count(json_decode($log->permission_update)->deleted) > 0)
                        @php
                            $deleted = json_decode($log->permission_update)->deleted;
                        @endphp

                        <br>{{'Deleted = '}}<br>
                        @foreach($deleted as $key => $val)
                            {{ucwords(str_replace('_', ' ', $val))}}<br>

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

                @else
                    <td>{{ 'Data Not Found' }}</td>
                @endif
                <td>{{Carbon\Carbon::parse($log->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

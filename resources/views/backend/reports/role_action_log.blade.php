@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Role Action Log Report')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('role_action_logs.index') }}" method="GET">
                    <label class="col-md-2 col-form-label">{{translate('Sort by action')}} :</label>
                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="type" class="text-center" style="width: 2rem!important;">
                              <option value="" class="text-center">--All --</option>
                                <option value="Create" @if($type=="Create") selected @endif class="text-center">Created</option>
                                <option value="Update" @if($type=="Update") selected @endif class="text-center">Updated</option>
                                <option value="Delete" @if($type=="Delete") selected @endif class="text-center">Deleted</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                                <input type="text" class="aiz-date-range form-control" name="date" value="{{ $date }}" placeholder="Select Date" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" />
                        </div>
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="user" class="text-center" style="width: 2rem!important;">
                                <option value="" class="text-center">--Select User--</option>
                                @foreach ($users as $elem)
                                {{-- @if($elem->id == $user) selected @endif (this issue must be fixed) --}}
                                <option value="{{ $elem->id }}" >{{ $elem->name }}</option>
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
                <div class="aiz-pagination mt-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

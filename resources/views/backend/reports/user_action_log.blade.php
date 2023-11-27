@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">User Action Log Report</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('user_action_logs.index') }}" method="GET">
                    <label class="col-md-2 col-form-label">Sort by User :</label>
                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="type" class="text-center" style="width: 2rem!important;">
                                <option value="" class="text-center">--All --</option>
                                  <option value="create" @if($type=="create") selected @endif class="text-center">Created</option>
                                  <option value="update" @if($type=="update") selected @endif class="text-center">Updateed</option>
                                  <option value="delete" @if($type=="delete") selected @endif class="text-center">Deleted</option>


                              </select>
                        </div>

                        <div class="col-md-3">

                            <select class="from-control aiz-selectpicker" name="user_id" class="text-center" data-live-search=true>
                              <option value="" class="text-center">--Select User --</option>
                              @foreach (App\Models\User::whereIn('id',$users)->get() as $staff)
                              <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                                <input type="text" class="aiz-date-range form-control" name="date" value="{{ $date }}" placeholder="Select Date" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" />
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                        @can('export_activity_logs')
                            <div class="col-md-1">
                                <button class="btn btn-light" type="submit" value="export" name="button">Export</button>
                            </div>
                        @endcan
                    </div>
                </form>

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>User Type</th>
                            <th>User New Type</th>
                            <th>Performed By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)

                        <tr>
                            @if($log->user_name == null)
                                <td>{{ $log->user->name ?? 'Deleted User' }}</td>
                            @else
                                <td>{{ $log->user_name ?? 'Deleted User'}}</td>
                            @endif
                            <td>{{ $log->action }}</td>
                            @if($log->user_type)
                                <td>{{ $log->user_type ?? $log->user->type }}</td>
                            @endif
                            @if($log->user_new_type)
                                <td>{{ $log->user_new_type ?? $log->user->type }}</td>
                            @endif
                            @if($log->performed_by_name)
                                <td>{{ $log->performed_by_name }}</td>
                            @elseif($log->performed_by_name == 0)
                                <td>{{ 'System' }}</td>
                            @elseif($log->performed_by_name == null)
                            <td>{{ 'System' }}</td>
                            @else
                                <td>{{ 'Deleted User' }}</td>
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

@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">Staff Action Log</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('staff_action_logs.index') }}" method="GET">
                    <label class="col-md-2 col-form-label">Sort by Action:</label>
                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="type" class="text-center" style="width: 2rem!important;">
                              <option value="" class="text-center">--All --</option>
                                <option value="Create" @if($type=="Create") selected @endif class="text-center">Create</option>
                                <option value="Update" @if($type=="Update") selected @endif class="text-center">Update</option>
                                <option value="Delete" @if($type=="Delete") selected @endif class="text-center">Delete</option>

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
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                        @can('export_activity_logs')
                            <div class="col-md-1">
                                <button class="btn btn-light" type="submit" value="export" name="button">Export</button>
                            </div>
                        @endcan
                    </div>

                        <label class="col-md-2 col-form-label">Sort by staff:</label>
                        <div class="form-group row ">
                            <div class="col-md-3">
                                <select class="from-control aiz-selectpicker" name="staff" class="text-center" style="width: 2rem!important;" data-live-search="true">
                                    <option value="" class="text-center">--Select Staff--</option>
                                    @foreach ($staffs as $elem)
                                    {{-- @if($elem->id == $user) selected @endif (this issue must be fixed) --}}
                                    <option value="{{ $elem->id }}" @if($elem->id == request()->staff??'') selected @endif >{{ $elem->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                </form>

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th >Staff</th>
                            <th>Action</th>
                            <th>Role</th>
                            <th>Performed By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                        <tr>
                            <td>{{$log->staff_name?$log->staff_name:'Not Found'}}</td>
                            <td>{{ $log->action }}</td>
                            <td>{{$log->role_name?$log->role_name:'Not Found'}}</td>
                            <td>{{ $log->user->name }}</td>
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

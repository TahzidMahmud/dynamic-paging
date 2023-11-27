@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Offer Action Log Report')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('offer_action_logs.index') }}" method="GET">
                    <label class="col-md-2 col-form-label">Sort by action :</label>
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

                            <th>Offer</th>
                            <th>Action</th>
                            <th >Performed By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)

                        @php
                            $user=$log->user;
                            $role=$log->role;
                        @endphp
                            <tr>
                                @if($log->offer_name)
                                    <td>{{ $log->offer_name }}</td>
                                @elseif($log->offer_id)
                                    <td>{{ $log->offer_id->title }}</td>
                                @else
                                    <td>{{ 'Deleted Product' }}</td>
                                @endif
                                    <td>{{ $log->action }}</td>
                                @if($log->user_name)
                                    <td>{{ $log->user_name }}</td>
                                @elseif($user)
                                    <td>{{ $user->name }}</td>
                                @else
                                    <td>Data Not Found</td>
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

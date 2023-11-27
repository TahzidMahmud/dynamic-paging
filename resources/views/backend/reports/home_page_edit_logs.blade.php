@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">{{translate('Report Action Log')}}</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('home_page_edit_logs.index') }}" method="GET">
                        <label class="col-md-2 col-form-label">{{translate('Sort by action')}} :</label>
                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="home_section" class="text-center" style="width: 2rem!important;">
                                <option value="" class="text-center">--Select Section Type--</option>
                                @foreach ($home_sections as $elem)
                                <option value="{{ $elem }}" @if($elem == $home_section) selected @endif>{{ $elem}}</option>
                                @endforeach
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
                                <option value="{{ $elem->id }}" @if($elem->id == $selected_user) selected @endif>{{ $elem->name }}</option>
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

                            <th>{{ translate('Action') }}</th>
                            <th >{{ translate('Home Section') }}</th>
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

                               <td>{{ $log->action }}</td>
                               <td>{{ $log->home_section }}</td>

                                @if($user)
                                    <td>{{ $user->name ?? 'Data Not Found' }}</td>
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

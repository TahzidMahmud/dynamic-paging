@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">Order Process Log</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('order_process_logs.index') }}" method="GET">
                    <label class="col-md-3 col-form-label">Sort by Staff:</label>
                    <label class="col-md-3 col-form-label">Sort by Status:</label>

                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="user_id" class="text-center">
                              <option value="" class="text-center">--Select Staff --</option>

                              @foreach (App\Models\User::whereIn('id',$users)->get() as $staff)
                                <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="new_stat" class="text-center">
                              <option value="" class="text-center">--Select New Status --</option>
                              @foreach ($new_stats as $new_stat)
                                <option value="{{ $new_stat }}" @if($new_stat==request()->new_stat??'') selected @endif>{{ $new_stat }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                                <input type="text" class="aiz-date-range form-control" name="date" value="{{ $date }}" placeholder="Select Date" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off" />
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-light" type="submit" value="export" name="button">Export</button>
                        </div>

                    </div>

                    <div class="form-group row ">

                            <div class="col-md-6">
                              <input type="text" class="form-control" name="order_code" placeholder="Put Order Code For Search">
                            </div>
                            <div class="col-md-3 ">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                    </div>
                </form>

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>Order-Code</th>
                            <th>Old Status</th>
                            <th>Updated Status</th>
                            <th>User</th>
                            <td>Contact</td>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                            @php
                                $order=$log->order;
                                $user=$log->user;
                            @endphp
                            <tr>
                                @if($order)
                                <td><a href="{{ route('orders.show',$order->id) }}">{{ $order->combined_order->code }}</a></td>
                               @else
                                <td>{{ $log->order_code }}</td>
                               @endif
                                <td>{{ $log->old_stat }}</td>
                                <td>{{ $log->new_stat }}</td>
                                @if ($log->user_name)
                                <td>{{ $log->user_name }}</td>
                                @elseif ($log->user->name)
                                <td>{{ $log->user->name }}</td>
                                @else
                                <td>{{ 'Deleted User' }}</td>
                                @endif

                                @if ($log->user)
                                    @if($log->user->email)
                                    <td>{{ $log->user->email ?? 'Deleted User'}}</td>
                                    @elseif($log->user->phone)
                                    <td>{{ $log->user->phone }}</td>
                                    @else
                                    <td>{{ 'Deleted User' }}</td>
                                    @endif
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

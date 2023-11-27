@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class=" align-items-center">
       <h1 class="h3">Product Action Log Report</h1>
	</div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('productlog.index') }}" method="GET">
                    <label class="col-md-2 col-form-label">Sort by User :</label>
                    <div class="form-group row ">
                        <div class="col-md-3">
                            <select class="from-control aiz-selectpicker" name="user_id" class="text-center">
                              <option value="" class="text-center">--Select User --</option>
                              @foreach (App\Models\User::whereIn('id',$users)->get() as $staff)
                              <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                            @endforeach
                            </select>
                        </div>
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
                        <div class="col-md-1">
                            <button class="btn btn-primary" type="submit">Filter</button>
                        </div>
                        @can('export_activity_logs')

                            <div class="col-md-1">
                                <button class="btn btn-light" type="submit" value="export" name="button">Export</button>
                            </div>
                        @endcan
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-7 offset-md-2">
                          <input type="text" class="form-control" name="product_name" placeholder="Search By Product Name">
                        </div>
                          <div class="col-md-2">
                              <button class="btn btn-primary" type="submit">Search</button>
                          </div>
                     </div>
                </form>

                <table class="table table-bordered aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th >Action</th>
                            <th >Data Change</th>
                            <th >User</th>
                            <td>Contact</td>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)

                        <tr>
                            @if($log->product_name == null)
                                <td>{{ $log->product->name ?? 'Deleted User' }}</td>
                            @else
                                <td>{{ $log->product_name ?? 'Deleted Product'}}</td>
                            @endif
                                <td>{{ $log->action }}</td>
                            @if($log->data_change)
                                <td>
                                    @if(property_exists(json_decode($log->data_change),'name'))
                                        {{'Name - '}}{{ json_decode($log->data_change)->name }}<br>
                                    @endif
                                    @if(property_exists(json_decode($log->data_change),'price'))
                                         {{'Price - '}}{{ json_decode($log->data_change)->price }}<br>
                                    @endif
                                    @if(property_exists(json_decode($log->data_change),'stock'))
                                         {{'Stock - '}}{{ json_decode($log->data_change)->stock }}<br>
                                    @endif
                                    @if(property_exists(json_decode($log->data_change),'discount'))
                                         {{'Discount - '}}{{ json_decode($log->data_change)->discount }} @if(property_exists(json_decode($log->data_change),'discount_type'))({{ json_decode($log->data_change)->discount_type }})@else {{ $log->product->discount_type}}@endif<br>
                                    @endif

                                    @if(property_exists(json_decode($log->data_change),'description'))
                                         {{'Description - Updated'}}<br>
                                    @endif

                                </td>
                            @else
                            <td></td>
                            @endif

                            @if($log->user_name)
                                <td>{{ $log->user_name ?? 'Deleted User' }}</td>
                            @elseif($log->user_id)
                                <td>{{ $log->user->name ?? 'Deleted User' }}</td>
                            @elseif($log->guest_id)

                                @php
                                    $temp_user = App\Models\CombinedOrder::where('user_id',$log->guest_id)->first();

                                    $order = App\Models\Order::where('combined_order_id',$temp_user->id)->first();
                                @endphp
                                @if($order)
                                <td>{{ 'Guest('.$order->guest_id.')' ?? 'Deleted User' }}</td>
                                @else
                                <td>{{ 'Guest('.$log->guest_id.')' ?? 'Deleted User' }}</td>
                                @endif
                            @else
                                <td>{{ 'Deleted User' }}</td>
                            @endif
                            @if($log->user->email ?? null)
                                <td>{{ $log->user->email ?? 'Deleted User' }}</td>
                            @elseif($log->user->phone ?? null)
                                <td>{{ $log->user->phone ?? 'Deleted User' }}</td>
                            @elseif($log->guest_id ?? null)
                                @if($order)
                                <td>{{ 'Guest('.$order->guest_id.')' ?? 'Deleted User' }}</td>
                                @else
                                <td>{{ 'Guest('.$log->guest_id.')' ?? 'Deleted User' }}</td>
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

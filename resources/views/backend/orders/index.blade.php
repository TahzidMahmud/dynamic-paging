@extends('backend.layouts.app')

@section('content')

    <div class="card">
        <form class="" id="sort_orders" action="" method="GET">

            <div class="card-header row gutters-5">

                <div class="col-xl-2 col-md-2 ml-auto">
                    <select class="form-control aiz-selectpicker" name="payment_status" onchange="sort_orders()"
                        data-selected="{{ $payment_status }}">
                        <option value="">{{ translate('Filter by Payment Status') }}</option>
                        <option value="paid">{{ translate('Paid') }}</option>
                        <option value="unpaid">{{ translate('Unpaid') }}</option>
                        <option value="partial">Partial</option>
                    </select>
                </div>

                <div class="col-xl-2 col-md-3">
                    <select class="form-control aiz-selectpicker" name="delivery_status" onchange="sort_orders()"
                        data-selected="{{ $delivery_status }}">
                        <option value="">{{ translate('Filter by Deliver Status') }}</option>
                        <option value="order_placed">{{ translate('Order placed') }}</option>
                        <option value="confirmed">{{ translate('Confirmed') }}</option>
                        <option value="processed">{{ translate('Processed') }}</option>
                        <option value="shipped">{{ translate('Shipped') }}</option>
                        <option value="delivered">{{ translate('Delivered') }}</option>
                        <option value="cancelled">{{ translate('Cancelled') }}</option>
                    </select>
                </div>
                <div class="col-xl-2 col-md-3 ">
                    <div class="form-group mb-0">
                        <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="{{ translate('Filter by date') }}"  onchange="sort_orders()" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                    </div>
                </div>
                <div class="col-xl-2 col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search" name="search" @isset($sort_search)
                            value="{{ $sort_search }}" @endisset
                            placeholder="{{ translate('Type Order code & hit Filter') }}">
                    </div>
                </div>
                <div class="col-xl-2 col-md-2">
                    <div class="input-group">
                        <input type="text" class="form-control" id="sku" name="sku" @isset($sku)
                            value="{{ $sku }}" @endisset
                            placeholder="{{ translate('Type SKU & Filter') }}">
                    </div>
                </div>
                <div class="col-md-1 ml-auto">
                    <button class="btn btn-warning" type="submit" value="export" name="button">Export</button>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-success" type="submit" value="submit" name="button">Filter</button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ translate('Order Code') }}</th>
                        <th data-breakpoints="lg">{{ translate('Num. of Products') }}</th>
                        <th data-breakpoints="lg">{{ translate('Customer') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th data-breakpoints="lg">{{ translate('Delivery Status') }}</th>
                        <th data-breakpoints="lg">{{ translate('Payment Status') }}</th>
                        <th data-breakpoints="lg" class="text-right" width="15%">{{ translate('options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>
                                {{ $key + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
                            </td>
                            <td>
                                @if(addon_is_activated('multi_vendor'))<div>{{ translate('Package') }} {{ $order->code }} {{ translate('of') }}</div>@endif
                                <div class="fw-600">{{ $order->combined_order->code ?? '' }}</div>
                                <div>  <span class="badge badge-inline badge-primary">{{ $order->type }}</span></div>
                            </td>
                            <td>
                                {{ count($order->orderDetails) }}
                            </td>
                            <td>
                                @if ($order->user != null)
                                    {{ $order->user->name }}
                                @else
                                    Guest ({{ $order->guest_id }})
                                @endif
                            </td>
                            <td>
                                {{ format_price($order->grand_total) }}
                            </td>
                            <td>
                                <span
                                    class="text-capitalize">{{ translate(str_replace('_', ' ', $order->delivery_status)) }}</span>
                            </td>
                            <td>
                                @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{ translate('Paid') }}</span>
                                @elseif ($order->payment_status=='partial')
                                    <span class="badge badge-inline badge-warning">{{ translate('Partial') }}</span>
                                @else
                                    <span class="badge badge-inline badge-danger">{{ translate('Unpaid') }}</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @can('view_orders')
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm"
                                        href="{{ route('orders.show', $order->id) }}" title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                @endcan
                                @can('invoice_download')
                                    <a class="btn btn-soft-success btn-icon btn-circle btn-sm"
                                        title="{{ translate('Print Invoice') }}" href="javascript:void(0)"
                                        onclick="print_invoice('{{ route('orders.invoice.print', $order->id) }}')">
                                        <i class="las la-print"></i>
                                    </a>
                                @endcan
                                @can('invoice_download')
                                    <a class="btn btn-soft-info btn-icon btn-circle btn-sm"
                                        href="{{ route('orders.invoice.download', $order->id) }}"
                                        title="{{ translate('Download Invoice') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                @endcan
                                @can('delete_orders')
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete"
                                        data-href="{{ route('orders.destroy', $order->id) }}"
                                        title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                @endcan
                                @can('delete_orders')

                                @can('manage_pos')
                                    @if ($order->delivery_status != 'delivered')
                                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-soft-warning btn-icon btn-circle btn-sm "
                                            title="{{ translate('Edit') }}">
                                            <i class="las la-pen"></i>
                                        </a>
                                    @endif
                                @endcan
                                <a class="btn btn-soft-secondary my-1 btn-icon btn-circle btn-sm" data-id="{{ $order->id }}" href="javascript:void(0)" onclick="viewNote(this)" title="Notes">
                                    <i class="las la-file"></i>
                                 </a>
                            @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>
        </div>
    </div>

@endsection

@section('modal')
    @include('backend.inc.delete_modal')
    @include('modals.note_view_modal')
@endsection

@section('script')
    <script type="text/javascript">
        function sort_orders(el) {
            console.log('hgiut');
            $('#sort_orders').submit();
        }

        function print_invoice(url) {
            var h = $(window).height();
            var w = $(window).width();
            window.open(url, '_blank', 'height=' + h + ',width=' + w + ',scrollbars=yes,status=no');
        }
        function viewNote(id){
            var t=$(id).data('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{route('order.notes')}}",
                type: 'POST',
                data: {
                    order_id:t
                },


                success: function (res) {
                    console.log(res.count)
                    if(res.count > 0){

                        $('#note_view').html(res.modal_view);
                        $("#note-view-modal").modal("show");
                    }else{
                        $('#note_view').html('<h4 class="text text-danger text-center">No Notes Found For This Order ..!</h4>');
                        $("#note-view-modal").modal("show");

                    }
                }
            });


        }
    </script>
@endsection

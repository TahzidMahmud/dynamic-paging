@extends('backend.layouts.app')

@section('content')

<section class="" id="app">
    <form class="" action="" method="POST" enctype="multipart/form-data">
        @csrf

        <order-edit-component :user="{{$user }}" :categories="{{ \App\Models\Category::query()->get(['id','name']) }}" :brands="{{ \App\Models\Brand::query()->get(['id','name']) }}" url="{{env('APP_URL') }}" csrftoken="{{csrf_token()}}" currency="{{ $symbol }}" :shipping={{ $order->shipping_cost}} :discount={{ $order->coupon_discount }}  :countries="{{ \App\Models\Country::where('status',1)->get(['id','name']) }}" :customers="{{ \App\Models\User::where('user_type','customer')->get()}}" :order="{{ $order }}" :order_carts="{{ $carts }}" :combined_order="{{ $combined_order }}"> </order-edit-component>
    </form>
</section>

@endsection

@section('modal')


@endsection


@section('script')
    <script type="text/javascript">

        var products = null;

        $(document).ready(function(){
            $('body').addClass('side-menu-closed');
            $('#product-list').on('click','.add-plus:not(.c-not-allowed)',function(){
                var stock_id = $(this).data('stock-id');
                $.post('{{ route('pos.addToCart') }}',{_token:AIZ.data.csrf, stock_id:stock_id}, function(data){
                    if(data.success == 1){
                        updateCart(data.view);
                    }else{
                        AIZ.plugins.notify('danger', data.message);
                    }

                });
            });
            // filterProducts();
            // getShippingAddress();
        });

        function add_new_address(){
             var customer_id = $('#customer_id').val();
            $('#set_customer_id').val(customer_id);
            $('#new-address-modal').modal('show');
            $("#close-button").click();
        }

        function orderConfirmation(){
            $('#order-confirmation').html(`<div class="p-4 text-center"><i class="las la-spinner la-spin la-3x"></i></div>`);
            $('#order-confirm').modal('show');
            $.post('{{ route('pos.getOrderSummary') }}',{_token:AIZ.data.csrf}, function(data){
                $('#order-confirmation').html(data);
            });
        }

    </script>
@endsection

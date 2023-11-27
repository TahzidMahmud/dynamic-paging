<?php

namespace App\Http\Controllers;

use App\Models\CommissionHistory;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderUpdate;
use App\Models\User;
use App\Models\Wallet;
use CoreComponentRepository;
use Excel;
use Session;
use DB;
use App\Exports\OrdersExport;
use App\Http\Services\SmsServices;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:show_orders'])->only('index');
        $this->middleware(['permission:view_orders'])->only('show');
        $this->middleware(['permission:delete_orders'])->only('destroy');
    }

    public function index(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $date = null;
        $sku=null;
        $admin = User::where('user_type','admin')->first();
        $orders = Order::with(['combined_order'])->where('shop_id',$admin->shop_id);
        if($request->sku!= null){
            $sku = $request->sku;
            $variation_id=\App\Models\ProductVariation::where('sku',$request->sku)->first();

            if($variation_id){
                $order_detail_ids=\App\Models\OrderDetail::where('product_variation_id',$variation_id->id)->pluck('order_id')->toArray();
                $orders = Order::whereIn('id',$order_detail_ids)->paginate(15);

                return view('backend.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search','date','sku'));

            }else{
                flash(translate('No Order Found With This SKU'))->error();
                return  back();
            }
        }
        if ($request->has('search') && $request->search != null ){
            $sort_search = $request->search;
            $orders = $orders->whereHas('combined_order', function ($query) use ($sort_search) {
                $query->where('code', 'like', '%'.$sort_search.'%');
            });
        }
        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($request->date != null) {
            $date=$request->date;
            if (date('Y-m-d', strtotime(explode(" to ", $date)[0])) == date('Y-m-d', strtotime(explode(" to ", $date)[1]))) {

                $orders = $orders->where('created_at', 'like', date('Y-m-d', strtotime(explode(" to ", $date)[0])) . '%');
            } else {

                $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

        }

        if($request->button == 'export'){
            return Excel::download(new OrdersExport($orders->latest()->get()), 'orders.xlsx');
        }
        $orders = $orders->latest()->paginate(15);

        return view('backend.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search','date','sku'));
    }
    public function pos_orders(Request $request){
        // CoreComponentRepository::instantiateShopRepository();

        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $date = null;
        $sku=null;
        $admin = User::where('user_type','admin')->first();
        $orders = Order::with(['combined_order'])->where('type','POS')->where('shop_id',$admin->shop_id);
        if($request->sku!= null){
            $sku = $request->sku;
            $variation_id=\App\Models\ProductVariation::where('sku',$request->sku)->first();

            if($variation_id){
                $order_detail_ids=\App\Models\OrderDetail::where('product_variation_id',$variation_id->id)->pluck('order_id')->toArray();
                $orders = Order::whereIn('id',$order_detail_ids)->paginate(15);

                return view('backend.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search','date','sku'));

            }else{
                flash(translate('No Order Found With This SKU'))->error();
                return  back();
            }
        }
        if ($request->has('search') && $request->search != null ){
            $sort_search = $request->search;
            $orders = $orders->whereHas('combined_order', function ($query) use ($sort_search) {
                $query->where('code', 'like', '%'.$sort_search.'%');
            });
        }
        if ($request->payment_status != null) {
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }

        if ($request->date != null) {
            $date=$request->date;
            if (date('Y-m-d', strtotime(explode(" to ", $date)[0])) == date('Y-m-d', strtotime(explode(" to ", $date)[1]))) {

                $orders = $orders->where('created_at', 'like', date('Y-m-d', strtotime(explode(" to ", $date)[0])) . '%');
            } else {

                $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

        }

        if($request->button == 'export'){
            return Excel::download(new OrdersExport($orders->latest()->get()), 'orders.xlsx');
        }
        $orders = $orders->latest()->paginate(15);

        return view('backend.orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search','date','sku'));
    }

    public function show($id)
    {
        $order = Order::with(['orderDetails.product','orderDetails.variation.combinations'])->findOrFail($id);
        return view('backend.orders.show', compact('order'));
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carts=[];
        $order=Order::with(['orderDetails.product','orderDetails.variation.combinations','combined_order','user'])->findOrFail($id);
        $user=$order->user;
        foreach($order->orderDetails as $key => $ordr){
            Session::put('order.edit', $order->id);

            // DB::table('temp_order_details')->where('order_id', $order->id)->delete();

            // $tempOrderDetail = new TempOrderDetail;
            // // dd($ordr);
            // $tempOrderDetail->fill($ordr->toArray());
            // $tempOrderDetail->save();
            $temp=\App\Models\ProductVariation::with(['product'])->find($ordr->product_variation_id)->toArray();

            $temp2=collect($temp);
            $order_date=$temp2->merge(collect($ordr->toArray()));

            array_push($carts,$order_date);
        };
        $combined_order=$order->combined_order;
        $symbol=currency_symbol();
        $carts=collect($carts);
        // dd($carts);

        return view('backend.orders.edit',compact('order','carts','user','combined_order','symbol'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->delete();
            }
            foreach($order->refundRequests as $key => $refundRequest){
                foreach($refundRequest->refundRequestItems as $key => $refundRequestItem){
                    $refundRequestItem->delete();
                }
                $refundRequest->delete();
            }

            $order_count = Order::where('combined_order_id',$order->combined_order_id)->count();
            if($order_count == 1){
                $order->combined_order->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_status = $request->status;
        $order->save();

        OrderUpdate::create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'note' => 'Order status updated to '.$request->status.'.',
        ]);
        if ($request->has('note')) {
            \App\Models\OrderNote::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'note' => $request->note,
                'status' => $request->status
            ]);

        }

        if ($request->status == 'cancelled') {
            foreach($order->orderDetails as $orderDetail){
                try{
                    foreach($orderDetail->product->categories as $category){
                        $category->sales_amount -= $orderDetail->total;
                        $category->save();
                    }

                    $brand = $orderDetail->product->brand;
                    if($brand){
                        $brand->sales_amount -= $orderDetail->total;
                        $brand->save();
                    }
                }
                catch(\Exception $e){

                }
            }
            if($order->payment_status == 'paid'){

                if($order->payment_type == 'wallet'){
                    $user = User::where('id', $order->user_id)->first();
                    $user->balance += $order->grand_total;
                    $user->save();

                    $wallet = new Wallet;
                    $wallet->user_id = $user->id;
                    $wallet->amount = $order->grand_total;
                    $wallet->details = 'Order Cancelled. Order Code '.$order->combined_order->code;
                    $wallet->save();
                }

                $shop = $order->shop;
                if($shop->user->user_type == 'seller'){
                    if ($order->payment_type == 'cash_on_delivery') {
                        // For Cash on Delivery admin commmision was deducted from the seller old balance. That's why the deducted commission amount have to add again.
                        $shop->current_balance += $order->admin_commission;

                        $commission = new CommissionHistory();
                        $commission->order_id = $order->id;
                        $commission->shop_id = $shop->id;
                        $commission->seller_earning = $order->admin_commission;
                        $commission->details = format_price($order->admin_commission).' is Added for Cash On Delivery Order Cancellation.';
                        $commission->save();
                    }
                    else{
                        $shop->current_balance -= $order->seller_earning;

                        $commission = new CommissionHistory();
                        $commission->order_id = $order->id;
                        $commission->shop_id = $shop->id;
                        $commission->seller_earning = $order->seller_earning;
                        $commission->type = 'Deducted';
                        $commission->details = format_price($order->seller_earning).' is Deducted for Order Cancellation.';
                        $commission->save();
                    }
                    $shop->save();
                }

            }

        }

        (new SmsServices)->orderUpdateSms($order->user->phone, $order->combined_order->code,$request->status);

        flash(translate('Delivery status has been updated.'))->success();

        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        if($order->payment_status == 'unpaid'){
            $order->payment_status = $request->status;
            $order->save();

            OrderUpdate::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'note' => 'Payment status updated to '.$request->status.'.',
            ]);

            if($request->status == 'paid'){
                calculate_seller_commision($order);
                $order->commission_calculated = 1;
                $order->save();
            }
            flash(translate('Payment status has been updated.'))->success();

        }elseif($order->payment_status == 'partial'){
            $order->payment_status = $request->status;
            $order->save();

            OrderUpdate::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'note' => 'Payment status updated to '.$request->status.'.',
            ]);

            if($request->status == 'paid'){
                calculate_seller_commision($order);
                $order->commission_calculated = 1;
                $order->save();
            }
            flash(translate('Payment status has been updated.'))->success();

        }else{
            flash(translate('Paid status can not be changed.'))->error();
        }

        return 1;
    }

    public function add_tracking_information(Request $request){

        $order = Order::findOrFail($request->order_id);

        if($order->courier_name){
            $update_note = 'Courier information updated';
        }else{
            $update_note = 'Courier information added';
        }

        $order->courier_name = $request->courier_name;
        $order->tracking_number = $request->tracking_number;
        $order->tracking_url = $request->tracking_url;
        $order->save();

        OrderUpdate::create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'note' => $update_note,
        ]);

        flash(translate('Courier information has been updated.'))->success();

        return back();
    }

    public function order_update(Request $request){



        $subtotal = 0;
        $details_ids=[];
        // combined order update
        if($request->has('advanced_payment_amount') &&  $request->advanced_payment_amount != null){
            $combined_order=\App\Models\CombinedOrder::find($request->combined_order);
            $combined_order->advanced_payment = $request->advanced_payment_amount;
            $combined_order->payment_note=$request->advanced_payment_note;
            $combined_order->save();

        }
        // order update
        $order = Order::findOrFail($request->order_id);
        $order->grand_total = $request->total;
        $order->coupon_discount=$request->discount;
        $order->shipping_cost=$request->shipping;
        $order->shipping_address=$request->address!='null'?$request->address:$order->shipping_address;
        $order->save();
        $order_details=(new \App\Models\OrderDetail)->where('order_id',$request->order_id)->get();
        foreach($order_details as $order_detail){
            $stock=\App\Models\ProductVariation::find($order_detail->product_variation_id)->first();
            $stock->update([
                'stock'=>$stock->stock+$order_detail->quantity
            ]);
            array_push($details_ids,$order_detail->id);
        }

        (new \App\Models\OrderDetail)->whereIn('id',$details_ids)->delete();
        // order details uopdtes
        foreach(json_decode($request->carts) as $cart){
            $orderDetail =  new \App\Models\OrderDetail();
            $orderDetail->order_id = $request->order_id;
            $orderDetail->product_id = $cart->product_id;
            $orderDetail->product_variation_id = $cart->product_variation_id;
            $orderDetail->quantity = $cart->quantity;
            $orderDetail->price = $cart->price;
            $orderDetail->total = ($orderDetail->price * $orderDetail->quantity);
            $subtotal += $orderDetail->total;
            $orderDetail->save();
        }

        return array('success' => 1, 'message' => '');
    }
    public function get_notes(Request $request)
    {
        $notes = \App\Models\OrderNote::where('order_id', $request->order_id)->get();

        return array(
            'count' => count($notes),
            'modal_view' => view('backend.partials.note_details', compact('notes'))->render(),

        );
    }
}

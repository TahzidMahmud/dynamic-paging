<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\TempOrderDetail;
use App\Models\OrderActionLog;
use App\Models\Product;
use Auth;
use DB;
use Session;
class OrderActionObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {

        if(Auth::check()){
            OrderActionLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'action' => 'Created',
                'type' => 'WEB',
                'order_code' => $order->code,
                'user_name' => auth()->user()->name,
                // 'data' => json_encode($order->toArray())
            ]);
            return 1;
        }else{
            $temp_user_id = Session()->get('temp_user_id');
            OrderActionLog::create([
                'order_id' => $order->id,
                'guest_id' => $temp_user_id,
                'action' => 'Created',
                'type' => 'WEB',
                'order_code' => $order->code,
                'user_name' => $temp_user_id,
                // 'data' => json_encode($order->toArray())
            ]);
            return 1;
        }
    }

    public function updating(Order $order){
        $change = [];
        if(Auth::check()){
            $auth_user = Auth::user();
            if($auth_user->user_type != 'customer' && $auth_user->user_type != 'seller' && Session::has('order.edit')){
                $request = request()->all();
                if(array_key_exists('carts', $request)){
                    $updated_orders = json_decode($request['carts']);
                    $updated_shipping_cost = Session::get('pos.shipping');
                    $updated_discount = Session::get('pos.discount');
                    $updated_advance_payment = $request['advanced_payment_amount'];
                    $old_order = $order;
                    $temp_old_orders = $order->orderDetails;
                    $old_orders_ids = [];
                    $updated_orders_ids = [];
                    $new_added = [];
                    $updated_data = [];

                    foreach($temp_old_orders as $key => $temp_old_order){
                        array_push($old_orders_ids,$temp_old_order->id);
                    }
                    foreach($updated_orders as $key => $updated_order){
                        if(array_key_exists('id', $updated_order)){
                            array_push($updated_orders_ids,$updated_order->id);
                        }else{
                            $new_added[$key] ['product_id'] = $updated_order->product_id;
                            $new_added[$key] ['product_name'] = Product::where('id',$updated_order->product_id)->first()->name;
                            $new_added[$key] ['product_variation_id'] = $updated_order->product_variation_id;
                            $new_added[$key] ['product_quantity'] = $updated_order->quantity;

                            unset($updated_orders[$key]);
                        }
                    }
                    if($updated_shipping_cost){
                        $change['shipping_cost'] = (double)$updated_shipping_cost;
                    }
                    if($updated_discount){
                        $change['discount'] = (double)$updated_discount;
                    }
                    if($updated_advance_payment != "null"){
                        $change['advance_payment'] = (double)$updated_advance_payment;
                    }
                    if(count($new_added) > 0){
                        $change['new_added'] = $new_added;
                    }

                    $deleted_products = array_diff($old_orders_ids, $updated_orders_ids);
                    if(count($deleted_products) > 0){
                        $deleted_data = $this->get_del_data($temp_old_orders,$deleted_products);
                        $change['deleted'] = $deleted_data;
                    }

                    $updated_data = $this->get_update_data($temp_old_orders,$updated_orders);
                    if($updated_data){
                        $change['updated'] = $updated_data;
                    }
                }


            }

            OrderActionLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->user()->id,
                'action' => 'Updated',
                'type' => 'WEB',
                'order_code' => $order->code,
                'user_name' => auth()->user()->name,
                'data_change' => !empty($change) ? json_encode($change) : null
            ]);
            Session::forget('order.edit');
            return 1;
        }else{

            $temp_user_id = Session()->get('temp_user_id');
            OrderActionLog::create([
                'order_id' => $order->id,
                'guest_id' => $temp_user_id,
                'action' => 'Updated',
                'type' => 'WEB',
                'order_code' => $order->code
                // 'user_name' => $temp_user_id,
                // 'data' => json_encode($order->toArray())
            ]);
            return 1;
        }

    }



    public function get_update_data($temp_old_orders,$updated_orders){

        $ret_array = [];
            foreach($temp_old_orders as $key => $temp){
                $temp2 = [];

                foreach($updated_orders as $ord){

                    if($ord->id == $temp->id){
                        if($ord->quantity != $temp->quantity){
                            $temp2 ['product_id'] = $temp->product_id;
                            $temp2 ['product_name'] = Product::where('id',$temp->product_id)->first()->name;
                            $temp2 ['product_variation_id'] = $temp->product_variation_id;
                            $temp2 ['product_quantity'] = $ord->quantity;
                            // dd($temp2);
                            array_push($ret_array,$temp2);
                        }
                    }
                }
            }
        return $ret_array;
    }

    public function get_new_data($updated_order,$new_orders){

        $ret_array = [];
        foreach($new_orders as $abc){
            foreach($updated_order as $temp){
                $tem2 = [];
                if(array_key_exists('id',$temp) && $temp->id == $abc){
                    $tem2 ['product_id'] = $updated_order->product_id;
                    $tem2 ['product_name'] = Product::where('id',$updated_order->product_id)->first()->name;
                    $tem2 ['product_variation_id'] = $updated_order->product_variation_id;
                    $tem2 ['product_quantity'] = $updated_order->quantity;
                    array_push($ret_array,$tem2);
                }
            }
        }
        return $ret_array;
    }
    public function get_del_data($temp_order_details,$deleted_products){
        $ret_array = [];
        foreach($deleted_products as $abc){
            foreach($temp_order_details as $temp){
                $temp2 = [];
                if($temp->id == $abc){
                    $temp2 ['product_id'] = $temp->product_id;
                    $temp2 ['product_name'] = Product::where('id',$temp->product_id)->first()->name;
                    $temp2 ['product_variation_id'] = $temp->product_variation_id;
                    $temp2 ['product_quantity'] = $temp->quantity;
                    array_push($ret_array,$temp2);
                }
            }
        }
        return $ret_array;
    }
    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {


        OrderActionLog::create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'action' => 'Deleted',
            'type' => 'WEB',
            'order_code' => $order->code,
            'user_name' => auth()->user()->name,
            // 'data' => json_encode($order->toArray())
        ]);
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        OrderActionLog::create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'action' => 'Restored',
            'type' => 'WEB',
            'order_code' => $order->code,
            'user_name' => auth()->user()->name,
            // 'data' => json_encode($order->toArray())
        ]);
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        OrderActionLog::create([
            'order_id' => $order->id,
            'user_id' => auth()->user()->id,
            'action' => 'Force Deleted',
            'type' => 'WEB',
            'order_code' => $order->code,
            'user_name' => auth()->user()->name,
            // 'data' => json_encode($order->toArray())
        ]);
    }

}

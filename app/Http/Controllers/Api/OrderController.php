<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Address;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderSingleCollection;
use App\Http\Services\SmsServices;
use App\Models\City;
use App\Models\CombinedOrder;
use App\Models\CommissionHistory;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Language;
use App\Models\OrderUpdate;
use App\Models\Shop;
use App\Models\State;
use App\Models\Wallet;
use App\Models\OfferSale;
use App\Models\Product;
use App\Notifications\OrderPlacedNotification;
use PDF;
use DB;
use Notification;

class OrderController extends Controller
{
    public function index()
    {
        return new OrderCollection(CombinedOrder::with(['user','orders.orderDetails.variation.product','orders.orderDetails.variation.combinations','orders.shop'])->where('user_id', auth('api')->user()->id)->latest()->paginate(12));
    }

    public function show($order_code)
    {
        $order = CombinedOrder::where('code',$order_code)->with(['user','orders.orderDetails.variation.product','orders.orderDetails.variation.combinations','orders.shop'])->first();
        if($order){
            if(auth('api')->user()->id == $order->user_id){
                return new OrderSingleCollection($order);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => translate("This order is not your. You can't check details of this order"),
                    'status' => 200
                ]);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => translate("No order found by this code"),
                'status' => 404
            ]);
        }
    }



    public function invoice_download(Request $request,$order_code)
    {
        $currency_code = env('DEFAULT_CURRENCY_CODE');

        $language_code = app()->getLocale();

        if(optional(Language::where('code', $language_code)->first())->rtl == 1){
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        }else{
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }


        if($currency_code == 'BDT' || $language_code == 'bd'){
            // bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        }elseif($currency_code == 'KHR' || $language_code == 'kh'){
            // khmer font
            $font_family = "'Hanuman','sans-serif'";
        }elseif($currency_code == 'AMD'){
            // Armenia font
            $font_family = "'arnamu','sans-serif'";
        }elseif($currency_code == 'ILS'){
            // Israeli font
            $font_family = "'Varela Round','sans-serif'";
        }elseif($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD'|| $language_code == 'ir'){
            // middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        }else{
            // general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::where('code',$order_code)->first();
        $pdf =  PDF::loadView('backend.invoices.invoice',[
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], [])->save(public_path('invoices/').'order-invoice-'.$order->code.'.pdf');

        $pdf = static_asset('invoices/'.'order-invoice-'.$order->code.'.pdf');

        try {
            return response()->json([
                'success' => true,
                'message' => translate('Invoice generated.'),
                'invoice_url' => $pdf
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => translate('Something went wrong!'),
                'invoice_url' => ''
            ]);
        }
    }

    public function cancel($order_id)
    {
        $order = Order::findOrFail($order_id);
        if(auth('api')->user()->id !==  $order->user_id){
            return response()->json(null, 401);
        }

        if($order->delivery_status == 'order_placed' && $order->payment_status == 'unpaid'){
            $order->delivery_status = 'cancelled';
            $order->save();

            foreach($order->orderDetails as $orderDetail){
                try{
                    foreach($orderDetail->product->categories as $category){
                        $category->sales_amount -= $orderDetail->total;
                        $category->save();
                    }
                    $product = $orderDetail->product;
                    if($product){
                        $product->stock -= $orderDetail->quantity;
                        $product->save();
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

            return response()->json([
                'success' => true,
                'message' => translate("Order has been cancelled"),
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => translate("This order can't be cancelled."),
            ]);
        }
    }

    public function store(Request $request)
    {
        $user = auth('api')->user();
        $cartItems = Cart::where('user_id', $user->id)->whereIn('id',$request->cart_item_ids)->with(['variation.product'])->get();
        $shippingAddress = Address::find($request->shipping_address_id);
        $billingAddress = Address::find($request->billing_address_id);
        $shippingState = State::with('zone')->find($shippingAddress->state_id);

        if($cartItems->count() < 1)
            return response()->json([
                'success' => false,
                'message' => translate('Your cart is empty. Please select a product.')
            ]);

        if(!$request->shipping_address_id)
            return response()->json([
                'success' => false,
                'message' => translate('Please select a shipping address.')
            ]);

        if(!$request->billing_address_id)
            return response()->json([
                'success' => false,
                'message' => translate('Please select a billing address.')
            ]);


        if(!$shippingState->zone)
            return response()->json([
                'success' => false,
                'message' => translate('Sorry, delivery is not available in this shipping address.')
            ]);

        foreach ($cartItems as $cartItem) {
            if(!$cartItem->variation->stock){
                return response()->json([
                    'success' => false,
                    'message' => $cartItem->variation->product->getTranslation('name').' '.translate('is out of stock.')
                ]);
            }
        }



        if($shippingAddress->city == 'Dhaka' || $shippingAddress->city == 'Dhaka City'){
            $shipping_cost=0;
            foreach($cartItems as $cart){
                // dd($cart);
                $product = Product::where('id',$cart['product_id'])->first();
                if($product->same_shipping_charge =='1'){
                    $shipping_cost += $product->shipping_in;
                }else{
                    $qty = (int)$product->shipping_in*(int)$cart['quantity'];
                    $shipping_cost += (int)$qty;
                }
            }
        }else{

            $shipping_cost=0;
            foreach($cartItems as $cart){
                $product = Product::where('id',$cart['product_id'])->first();
                if($product->same_shipping_charge =='1'){
                    $shipping_cost += $product->shipping_out;
                }else{
                    $qty = (int)$product->shipping_out*(int)$cart['quantity'];
                    $shipping_cost += (int)$qty;
                }
            }
        }

        // generate array of shops cart items
        $shops_cart_items = array();
        foreach ($cartItems as $cartItem){
            $cart_ids = array();
            $product = $cartItem->variation->product;
            if(isset($shops_cart_items[$product->shop_id])){
                $cart_ids = $shops_cart_items[$product->shop_id];
            }
            array_push($cart_ids, $cartItem->id);

            $shops_cart_items[$product->shop_id] = $cart_ids;
        }

        // get coupon data based on request
        $coupons = collect();
        if ($request->coupon_codes && !empty($request->coupon_codes)) {
            $coupons = Coupon::where(function ($query) use ($request) {
                foreach ($request->coupon_codes as $coupon_code){
                    $query->orWhere('code', $coupon_code);
                }
            })->get();
        }



        $combined_order = new CombinedOrder;
        $combined_order->user_id = $user->id;
        $combined_order->code = date('Ymd-His') . rand(10, 99);
        $combined_order->shipping_address = json_encode($shippingAddress);
        $combined_order->billing_address = json_encode($billingAddress);
        $combined_order->save();

        $grand_total = 0;

        // all shops order place
        $package_number = 1;
        foreach ($shops_cart_items as $shop_id => $shop_cart_item_ids) {

            $shop_cart_items = $cartItems->whereIn('id', $shop_cart_item_ids);

            $shop_subTotal = 0;
            $shop_tax = 0;
            $shop_coupon_discount = 0;

            //shop total amount calculation
            foreach ($shop_cart_items as $cartItem) {
                $itemPriceWithoutTax = variation_discounted_price($cartItem->variation->product,$cartItem->variation,false)*$cartItem->quantity;
                $itemTax = product_variation_tax($cartItem->variation->product,$cartItem->variation)*$cartItem->quantity;

                $shop_subTotal += $itemPriceWithoutTax;
                $shop_tax += $itemTax;
            }
            $shop_total = $shop_subTotal + $shop_tax;


            // shop coupon check & disount calculation
            if ($request->coupon_codes && !empty($request->coupon_codes)) {

                $coupon = $coupons->firstWhere('shop_id', $shop_id);
                if($coupon){
                    $shop_coupon_discount = (new CouponController)->calculate_discount($coupon, $shop_total, $shop_cart_items);

                    $shop_total -= $shop_coupon_discount;

                    $coupon_usage = new CouponUsage();
                    $coupon_usage->user_id = $user->id;
                    $coupon_usage->coupon_id = $coupon->id;
                    $coupon_usage->save();
                }
            }

            $shop_total = $shop_total + $shipping_cost;

            // shop order place
            $order = Order::create([
                'user_id' => auth('api')->user()->id,
                'shop_id' => $shop_id,
                'combined_order_id' => $combined_order->id,
                'code' => $package_number,
                'shipping_address' => json_encode($shippingAddress),
                'billing_address' => json_encode($billingAddress),
                'shipping_cost' => $shipping_cost,
                'grand_total' => $shop_total,
                'coupon_code' => $coupon->code ?? null,
                'coupon_discount' => $shop_coupon_discount,
                'payment_type' => $request->payment_type,
            ]);

            $package_number++;
            $grand_total += $shop_total;


            foreach ($shop_cart_items as $cartItem) {
                $itemPriceWithoutTax = variation_discounted_price($cartItem->variation->product,$cartItem->variation,false);
                $itemProfit = (variation_discounted_price($cartItem->variation->product,$cartItem->variation,false) - $cartItem->variation->purchase_price)*$cartItem->quantity;
                $itemTax = product_variation_tax($cartItem->variation->product,$cartItem->variation);

                $orderDetail = OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_variation_id' => $cartItem->product_variation_id,
                    'price' => $itemPriceWithoutTax,
                    'profit' => $itemProfit,
                    'tax' => $itemTax,
                    'total' => ($itemPriceWithoutTax+$itemTax)*$cartItem->quantity,
                    'quantity' => $cartItem->quantity,
                ]);

                if(product_exists_in_live_offer($orderDetail->product_id)){
                    $offer_id=product_offer($orderDetail->product_id);

                    $offer_sale=OfferSale::create([
                        'offer_id'=>$offer_id,
                        'order_detail_id'=>$orderDetail->id,
                        'order_id'=>$order->id,
                        'product_id'=>$orderDetail->product_id,
                        'price'=>$itemPriceWithoutTax,
                        'profit' => $itemProfit,
                        'qty_sold'=> $cartItem->quantity,
                    ]);

                }

                $cartItem->product->update([
                    'num_of_sale' => DB::raw('num_of_sale + ' . $cartItem->quantity),
                    'stock' => DB::raw('stock - ' . $cartItem->quantity)

                ]);

                foreach($orderDetail->product->categories as $category){
                    $category->sales_amount += $orderDetail->total;
                    $category->save();
                }

                $brand = $orderDetail->product->brand;
                if($brand){
                    $brand->sales_amount += $orderDetail->total;
                    $brand->save();
                }

            }

            $order_price = $order->grand_total - $order->shipping_cost - $order->orderDetails->sum(function ($t) {
                return $t->tax * $t->quantity;
            });

            $shop_commission = Shop::find($shop_id)->commission;
            $admin_commission = 0.00;
            $seller_earning = $shop_total;
            if($shop_commission > 0){
                $admin_commission = ($shop_commission * $order_price) / 100;
                $seller_earning = $shop_total - $admin_commission;
            }

            $order->admin_commission = $admin_commission;
            $order->seller_earning = $seller_earning;
            $order->commission_percentage = $shop_commission;
            $order->save();

            OrderUpdate::create([
                'order_id' => $order->id,
                'user_id' => auth('api')->user()->id,
                'note' => 'Order has been placed.',
            ]);

        }

        $combined_order->grand_total = $grand_total;
        $combined_order->save();

        // clear user's cart
        Cart::destroy($request->cart_item_ids);

        if($request->payment_type == 'wallet'){
            $user->balance -= $combined_order->grand_total;
            $user->save();

            $wallet = new Wallet;
            $wallet->user_id = $user->id;
            $wallet->amount = $combined_order->grand_total;
            $wallet->type = 'Deducted';
            $wallet->details = 'Order Placed. Order Code '.$combined_order->code;
            $wallet->save();

            $this->paymentDone($combined_order, $request->payment_type);
        }

        $adminPhone = get_setting('sms_update_number_admin');

        try {

            (new SmsServices)->orderPlaceSms($user->phone, $combined_order->code);
            (new SmsServices)->orderPlaceAdminSms($adminPhone, $combined_order->code);

            Notification::send($user, new OrderPlacedNotification($combined_order));

        }catch(\Exception $e) {

        }

        if($request->payment_type =='cash_on_delivery' || $request->payment_type == 'wallet'){
            return response()->json([
                'success' => true,
                'go_to_payment' => false,
                'grand_total' => $grand_total,
                'payment_method' => $request->payment_type,
                'message' => translate('Your order has been placed successfully'),
                'order_code' => $combined_order->code
            ]);
        }else{
            return response()->json([
                'success' => true,
                'go_to_payment' => false,
                'grand_total' => $grand_total,
                'payment_method' => $request->payment_type,
                'message' => translate('Your order has been placed successfully'),
                'order_code' => $combined_order->code
            ]);
        }
    }

    public function get_shipping_cost(Request $request){
        // $address = Address::find($address_id);
        // $state = State::find($address->state_id);

        // if($state && $state->zone != null){
        //     return response()->json([
        //         'success' => true,
        //         'flat_delivery_cost' => $state->zone->flat_delivery_cost,
        //     ]);
        // }else{
        //     return response()->json([
        //         'success' => false,
        //         'flat_delivery_cost' => 0,
        //     ]);
        // }

        // $cartProducts = $request->cartProducts;
        $user = auth('api')->user();
        $cartProducts = Cart::where('user_id', $user->id)->whereIn('id',$request->cart_item_ids)->with(['variation.product'])->get();
        // dd($user);
        $address = Address::find($request->addressId);

        if($address->city == 'Dhaka' || $address->city == 'Dhaka City'){
            $shipping_cost=0;
            foreach($cartProducts as $cart){
                $product = Product::where('id',$cart['product_id'])->first();
                if($product->same_shipping_charge=='1'){
                    $shipping_cost += $product->shipping_in;
                }else{
                    $qty = (int)$product->shipping_in*$cart['quantity'];
                    $shipping_cost += (int)$qty;
                }
            }
            return response()->json([
                        'success' => true,
                        'qty'=>$cart['quantity'],
                        'shipping_cost' => $shipping_cost,
                    ]);
        }else{

            $shipping_cost=0;
            foreach($cartProducts as $cart){
                $product = Product::where('id',$cart['product_id'])->first();
                if($product->same_shipping_charge == '1'){
                    $shipping_cost += $product->shipping_out;
                }else{
                    $qty = (int)$product->shipping_out*(int)$cart['quantity'];
                    $shipping_cost += (int)$qty;
                }
            }
            return response()->json([
                        'success' => true,
                        'shipping_cost' => $shipping_cost,
                    ]);
        }


    }

    public function paymentDone($combined_order,$payment_method,$payment_info = null){

        foreach($combined_order->orders as $order){

            // commission calculation
            calculate_seller_commision($order);

            $order->payment_status = 'paid';
            $order->payment_type = $payment_method;
            $order->commission_calculated = 1;
            $order->payment_details = $payment_info;
            $order->save();
        }


    }
}

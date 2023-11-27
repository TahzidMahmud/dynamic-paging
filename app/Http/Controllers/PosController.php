<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\Models\OtpConfiguration;
use App\Models\BusinessSetting;
use App\Models\OrderDetail;
use App\Models\ProductVariation;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use App\Models\Color;
use App\Models\City;
use App\Models\User;
use App\Models\OrderActionLog;
use App\Models\Address;
use App\Models\CombinedOrder;
use App\Models\Country;
use App\Models\State;
use Session;
use Auth;
use DB;
use PDF;
use Mail;
use Illuminate\Support\Facades\Hash;

use App\Mail\InvoiceEmailManager;
use App\Http\Resources\PosProductCollection;
use App\Utility\CategoryUtility;

class PosController extends Controller
{
    public function index()
    {
        if (1) {
            $symbol=currency_symbol();
            $customers=\App\Models\User::where('user_type','customer')->get(['id','name','email']);
            return view('pos.index',compact('symbol','customers'));
        }
        else {
            // $pos_activation = BusinessSetting::where('type', 'pos_activation_for_seller')->first();
            // if ($pos_activation != null && $pos_activation->value == 1) {
            //     return view('pos.frontend.seller.pos.index');
            // }
            // else {
            //     flash(translate('POS is disable for Sellers!!!'))->error();
            //     return back();
            // }
        }
    }

    public function search(Request $request)
    {
        // dd($request);

        if($request->user_type == 'admin' || $request->user_type == 'staff'){
            $products = ProductVariation::join('products','product_variations.product_id', '=', 'products.id')->select('products.*','product_variations.id as stock_id','product_variations.sku','product_variations.price as stock_price', 'product_variations.stock as stock_qty', 'product_variations.img as stock_image','product_variations.code as code','product_variations.sku as sku')->orderBy('products.created_at', 'asc');
            // dd($products);
            // $products = ProductVariation::join('products','product_variations.product_id', '=', 'products.id')->select('products.*','product_variations.id as stock_id','product_variations.sku','product_variations.price as stock_price', 'product_variations.stock as stock_qty', 'product_variations.img as stock_image','product_variations.code as code','product_variations.sku as sku')->orderBy('products.created_at', 'asc');
            // $products = Product::where('added_by', 'admin')->where('published', '1');
        }
        else {
            $products = ProductVariation::join('products','product_variations.product_id', '=', 'products.id')->where('user_id', $request->id)->where('published', '1')->select('products.*','product_variations.id as stock_id','product_variations.variant','product_variations.price as stock_price', 'product_variations.qty as stock_qty', 'product_variations.image as stock_image')->orderBy('products.created_at', 'desc');
            // $products = Product::where('user_id', Auth::user()->id)->where('published', '1');
        }

        if($request->category != null){
            // $arr = explode('-', $request->category);
            // if($arr[0] == 'category'){
            //     $category_ids = CategoryUtility::children_ids($arr[1]);
            //     $category_ids[] = $arr[1];
            //     $products = $products->whereIn('products.category_id', $category_ids);
            // }
            $cat_p=\App\Models\ProductCategory::where('category_id',$request->category)->pluck('product_id')->toArray();

            $products = $products->whereIn('products.id', $cat_p);

        }

        if($request->brand != null){
            $products = $products->where('products.brand_id', $request->brand);
        }

        if ($request->keyword != null) {
            $products = $products->where('products.name', 'like', '%'.$request->keyword.'%');
        }

        /*$p = $products->get();

        // dd($p);*/

        // dd($products->paginate(10));

        $stocks = new PosProductCollection($products->paginate(16));
        // $stocks->appends(['keyword' =>  $request->keyword]);

        return $stocks;
    }

    public function addToCart(Request $request)
    {
        $stock = ProductVariation::find($request->stock_id);
        $product = $stock->product;

        $data = array();
        $data['stock_id'] = $request->stock_id;
        $data['id'] = $product->id;
        $data['variant'] = $stock->variant;
        $data['quantity'] = $product->min_qty;

        if($stock->stock < $product->min_qty){
            return array('success' => 0, 'message' => translate("This product doesn't have enough stock for minimum purchase quantity ").$product->min_qty, 'view' => view('pos.cart')->render());
        }

        $tax = 0;
        $price = $stock->price;

        // discount calculation
        $discount_applicable = false;
        if ($product->discount_start_date == null) {
            $discount_applicable = true;
        }
        elseif (strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date) {
            $discount_applicable = true;
        }
        if ($discount_applicable) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        //tax calculation
        foreach ($product->taxes as $product_tax) {
            if($product_tax->tax_type == 'percent'){
                $tax += ($price * $product_tax->tax) / 100;
            }
            elseif($product_tax->tax_type == 'amount'){
                $tax += $product_tax->tax;
            }
        }

        $data['price'] = $price;
        $data['tax'] = $tax;

        if($request->session()->has('pos.cart')){
            $foundInCart = false;
            $cart = collect();

            foreach ($request->session()->get('pos.cart') as $key => $cartItem){
                if($cartItem['id'] == $product->id && $cartItem['stock_id'] == $stock->id){
                    $foundInCart = true;
                    $loop_product = \App\Models\Product::find($cartItem['id']);
                    $product_stock = $loop_product->variations->where('id', $cartItem['stock_id'])->first();

                    if($product_stock->stock >= ($cartItem['quantity'] + 1)){
                        $cartItem['quantity'] += 1;
                    }else{
                        return array('success' => 0, 'message' => translate("This product doesn't have more stock."), 'cart' => Session::get('pos.cart'));
                    }
                }
                $cart->push($cartItem);
            }

            if (!$foundInCart) {
                $cart->push($data);
            }
            $request->session()->put('pos.cart', $cart);
        }
        else{
            $cart = collect([$data]);
            $request->session()->put('pos.cart', $cart);
        }

        $request->session()->put('pos.cart', $cart);

        return array('success' => 1, 'message' => '', 'cart' => Session::get('pos.cart'));
    }

    public function get_cart(Request $request){
        return array('success' => 1, 'message' => '', 'cart' => Session::get('pos.cart'));
    }
    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $cart = $request->session()->get('pos.cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request) {

            if($key == $request->key){
                $product = \App\Models\Product::find($object['id']);
                $product_stock = $product->variations->where('id', $object['stock_id'])->first();

                if($product_stock->stock >= $request->quantity){
                    $object['quantity'] = $request->quantity;
                }else{
                    return array('success' => 0, 'message' => translate("This product doesn't have more stock."), 'view' => Session::get('pos.cart'));
                }
            }
            return $object;
        });
        $request->session()->put('pos.cart', $cart);

        return array('success' => 1, 'message' => '', 'view' => Session::get('pos.cart'));
    }

    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if(Session::has('pos.cart')){
            $cart = Session::get('pos.cart', collect([]));
            // dd($cart,$request);
            $cart->forget($request->key);
            Session::put('pos.cart', $cart);

            $request->session()->put('pos.cart', $cart);
        }

        return array('success' => 1, 'message' => '', 'cart' => $cart);
    }

    //Shipping Address for admin
    public function getShippingAddress(Request $request){
        $user_id = $request->id;

        if($user_id == ''){
            $addresses=\App\Models\Address::where('user_id',$user_id)->get();
            return array('success' => 1, 'message' => '','addresses'=>$addresses);
        }
        else{
            // return view('pos.shipping_address', compact('user_id'));
            $addresses=\App\Models\Address::where('user_id',$user_id)->get();
            return array('success' => 1, 'message' => '','addresses'=>$addresses);
        }
    }

    //Shipping Address for seller
    public function getShippingAddressForSeller(Request $request){
        $user_id = $request->id;
        if($user_id == ''){
            return view('pos.frontend.seller.pos.guest_shipping_address');
        }
        else{
            return view('pos.frontend.seller.pos.shipping_address', compact('user_id'));
        }
    }

    public function set_shipping_address(Request $request) {

        if ($request->address_id != null) {
            $address = Address::findOrFail($request->address_id);
            $data['id']=$address->id;
            $data['name'] = $address->user->name;
            $data['email'] = $address->user->email;
            $data['address'] = $address->address;
            $data['country'] = $address->country;
            $data['city'] = $address->city;
            $data['state'] = $address->state;
            $data['postal_code'] = $address->postal_code;
            $data['phone'] = $address->phone;

        }
        $shipping_info = $data;
        $request->session()->put('pos.shipping_info', $shipping_info);
        return response([
            "address"=>Session::get('pos.shipping_info')
        ]);
    }

    //set Discount
    public function setDiscount(Request $request){
        if($request->discount >= 0){
            Session::put('pos.discount', $request->discount);
        }
        return array('success' => 1, 'message' => '', 'discount' => Session::get('pos.discount'));
    }

    //set Shipping Cost
    public function setShipping(Request $request){
        if($request->shipping != null){
            Session::put('pos.shipping', $request->shipping);
        }
        return array('success' => 1, 'message' => '', 'shipping' => Session::get('pos.shipping'));

    }

    //order summary
    public function get_order_summary(Request $request){
        return view('pos.order_summary');
    }

    //order place
    public function order_store(Request $request){

        if(Session::has('pos.cart') && count(Session::get('pos.cart')) > 0){

            $name = '';
            $email = '';
            $address = '';
            $country = '';
            $city = '';
            $postal_code = '';
            $phone = '';

            $user           = User::findOrFail($request->user_id);
            $name   = $user->name;
            $email  = $user->email;

            if($request->shipping_address != null){
                $address_data   = Address::findOrFail($request->shipping_address);
                $address        = $address_data->address;
                $country        = $address_data->country;
                $city           = $address_data->city;
                $state          = $address_data->state;
                $postal_code    = $address_data->postal_code;
                $phone          = $address_data->phone;
            }
            $data['id']           = $request->shipping_address;
            $data['name']           = $name;
            $data['email']          = $email;
            $data['address']        = $address;
            $data['country']        = $country;
            $data['city']           = $city;
            $data['state']           = $state;
            $data['postal_code']    = $postal_code;
            $data['phone']          = $phone;
            $shop_cart_items=Session::get('pos.cart');

            $combined_order = new CombinedOrder;
            $combined_order->user_id = $user->id;
            $combined_order->code = date('Ymd-His') . rand(10, 99);
            if($request->has('advanced_payment_amount') && $request->advanced_payment_amount !=null){
                $combined_order->advanced_payment = $request->advanced_payment_amount;
                $combined_order->payment_note = $request->advanced_payment_note;

            }
            $combined_order->shipping_address = json_encode($data);
            $combined_order->billing_address = json_encode($data);
            $combined_order->save();

            $grand_total = 0;
            // all shops order place
            $package_number = 1;


            $order = new Order;
            $order->user_id = $request->user_id;
            $order->shipping_address = json_encode($data);
            $order->billing_address= json_encode($data);
            $order->payment_type = $request->payment_type;
            $order->shop_id=6;
            // $order->delivery_viewed = '0';
            // $order->payment_status_viewed = '0';
            $order->code = 1;
            $order->combined_order_id = $combined_order->id;
            $order->date = strtotime('now');
            $order->payment_status = $request->pay_status;
            $order->shipping_cost=$request->shipping;
            $order->coupon_discount=$request->discount;
            $order->type="POS";
            $order->payment_details = $request->payment_type;

            $shipping_info = Session::get('pos.shipping_info');
            try{
                // commission_calculation($order);
                $order->commission_calculated = 1;
            }catch(\Exception $e){
                dd($e);
            }

            if($order->save()){

                $subtotal = 0;
                $tax = 0;
                foreach ($shop_cart_items as $key => $cartItem){
                    $product_stock = ProductVariation::find($cartItem['stock_id']);
                    $product = $product_stock->product;
                    $product_variation = $product_stock->variant;

                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                    $tax += $cartItem['tax']*$cartItem['quantity'];


                    if($cartItem['quantity'] > $product_stock->stock){
                        $order->delete();
                        return array('success' => 0, 'message' => $product->name.' ('.$product_variation.') '." just stock outs.");
                    }
                    else {
                        $product_stock->stock -= $cartItem['quantity'];
                        $product_stock->save();
                    }

                    $order_detail = new OrderDetail;
                    $order_detail->order_id  =$order->id;
                    // $order_detail->seller_id = $product->user_id;
                    $order_detail->product_id = $product->id;
                    // $order_detail->payment_status = 'paid';
                    $order_detail->product_variation_id = $product_stock->id;
                    $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                    $order_detail->profit = ($cartItem['price'] - $product_stock->purchase_price) * $cartItem['quantity'];
                    $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                    $order_detail->quantity = $cartItem['quantity'];
                    // $order_detail->shipping_type = null;

                    // if (Session::get('pos.shipping', 0) >= 0){
                    //     $order_detail->shipping_cost = Session::get('pos.shipping', 0)/count(Session::get('pos.cart'));
                    // }
                    // else {
                    //     $order_detail->shipping_cost = 0;
                    // }

                    $order_detail->save();

                    $product->num_of_sale++;
                    $product->save();
                }

                $order->grand_total = $subtotal + $tax + Session::get('pos.shipping', 0);

                if(Session::has('pos.discount')){
                    $order->grand_total -= Session::get('pos.discount');
                    $order->coupon_discount = Session::get('pos.discount');
                }

                $order->save();
                $combined_order->grand_total=$order->grand_total;
                $combined_order->save();


                // commission_calculation($order);

                // $order->commission_calculated = 1;


                Session::forget('pos.shipping_info');
                Session::forget('pos.shipping');
                Session::forget('pos.discount');
                Session::forget('pos.cart');
               return array('success' => 1, 'message' => translate('Order Completed Successfully.'));
            }
            else {
                return array('success' => 0, 'message' => translate('Please input customer information.'));
            }
        }
        return array('success' => 0, 'message' => translate("Please select a product."));
    }

    public function pos_activation()
    {
        // $pos_activation = BusinessSetting::where('type', 'pos_activation_for_seller')->first();
        return view('pos.pos_activation', compact('pos_activation'));
    }
    public function get_state(Request $request){
        $states=\App\Models\State::where('country_id',$request->country_id)->get();
       if($states){
            return array('success' => 1, 'message' => translate("Please select a product."),'states'=>$states);
       }else{}
    }

    public function get_city(Request $request){
        $cities=\App\Models\City::where('state_id',$request->state_id)->get();
        if($cities){
             return array('success' => 1, 'message' => translate("Please select a product."),'cities'=>$cities);
        }else{}
    }
    public function createShippingAddress(Request $request)
    {
        $new_user=null;

       if($request->user_id=='null'){

            try{
                $new_user=\App\Models\User::create([
                    'name'=> $request->name,
                    'email'=>$request->email,
                    'phone'=> '+88'.$request->phone,
                    'password'=>Hash::make('123456'),
                    'email_verified_at' => date('Y-m-d h:m:s')
                ]);
            }catch(\Exception $e){
                $new_user=false;
                // flash(translate('Already Email Or Phone Number is taken'))->error();

            }
       }
        $is_first=Address::where('user_id',$request->user_id)->first();

        $address = new Address;
        $address->user_id =$new_user!=null?$new_user->id:$request->user_id;
        $address->address = $request->address;
        $address->country = Country::find($request->country)->name;
        $address->country_id = $request->country;
        $address->state = State::find($request->state)->name;
        $address->state_id = $request->state;
        $address->city = City::find($request->city)->name;
        $address->city_id = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->default_shipping = $is_first!=null? 0 : 1;
        $address->default_billing = $is_first!=null? 0 : 1;
        $address->save();
        $request->session()->put('pos.shipping_info', $address);
        return response()->json([
            'success' => true,
            'address' => [
                'id'      => $address->id,
                'user_id' => $address->user_id,
                'address' => $address->address,
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'postal_code' => $address->postal_code,
                'phone' => $address->phone,
                'default_shipping' => $address->default_shipping,
                'default_billing' => $address->default_billing
            ],
            'user'=>$new_user,
            'message' => translate('Address has been added successfully.')
        ]);
    }
    public function advanced(Request $request){
        if($request->shipping != null){
            Session::put('pos.advanced_paymnet', $request->advanced_paymnet);
        }
        return array('success' => 1, 'message' => '', 'advanced_paymnet' => Session::get('pos.advanced_paymnet'));
    }
    public function filter_customer(Request $request){

       $customers=\App\Models\User::Where('phone','+88'.$request->cus_q)->orWhere('email',$request->cus_q)->orWhere('name','like','%'.$request->cus_q.'%')->get(['id','email','name']);
       return array('success' => 1, 'message' => '', 'customers' => $customers);

    }
}

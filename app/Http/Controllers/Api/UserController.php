<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\UserCollection;
use App\Models\CombinedOrder;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Upload;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $total_order_products = OrderDetail::distinct()
                                        ->whereIn('order_id', Order::where('user_id', auth('api')->user()->id)->pluck('id')->toArray());

        $recent_purchased_products = Product::whereIn('id',$total_order_products->pluck('product_id')->toArray())->limit(10)->get();
        $last_recharge = Wallet::where('user_id',auth('api')->user()->id)->latest()->first();

        return response()->json([
            'success' => true,
            'total_orders' => CombinedOrder::where('user_id', auth('api')->user()->id)->count(),
            'recent_orders' => new OrderCollection(CombinedOrder::with(['user','orders.orderDetails.variation.product','orders.orderDetails.variation.combinations','orders.shop'])->where('user_id', auth('api')->user()->id)->latest()->limit(10)->get()),
        ]);
    }
    public function info()
    {
        $user = User::find(auth('api')->user()->id);

        return response()->json([
            'success' => true,
            'user' => new UserCollection($user),
            'followed_shops' => $user->followed_shops->pluck('id')->toArray()
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = User::find(auth('api')->user()->id);

        $filtered_name = "";
        $email = "";

        $filtered_name = preg_replace("/[!\"`'#%&,:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/", " ", $request->name);
        $filtered_name = trim($filtered_name);

        if ($request->phone != null && strlen($request->phone) == 11 && preg_match("/^[0-9]*$/", $request->phone)) {
            $phone = $request->phone;
        } else {
            flash(translate('Invalid Phone Number.'))->error();
            return back();
        }
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL) && filter_var($request->email, FILTER_SANITIZE_EMAIL)) {
            $email = trim($request->email);
        }


        if($request->hasFile('avatar')){
            $upload = new Upload;
            $upload->file_original_name = null;
            $arr = explode('.', $request->file('avatar')->getClientOriginalName());

            for($i=0; $i < count($arr)-1; $i++){
                if($i == 0){
                    $upload->file_original_name .= $arr[$i];
                }
                else{
                    $upload->file_original_name .= ".".$arr[$i];
                }
            }

            $upload->file_name = $request->file('avatar')->store('uploads/all');
            $upload->user_id = $user->id;
            $upload->extension = $request->file('avatar')->getClientOriginalExtension();
            $upload->type = 'image';
            $upload->file_size = $request->file('avatar')->getSize();
            $upload->save();

            $user->update([
                'avatar' => $upload->id,
            ]);
        }
        $user->update([
            'name' => $filtered_name,
            'email' => $email,
            'phone' => $phone
        ]);

        return response()->json([
            'success' => true,
            'message' => translate('Profile information has been updated successfully'),
            'user' => new UserCollection($user)
        ]);
    }
    public function updatePassword(Request $request)
    {
        $user = User::find(auth('api')->user()->id);
        if (Hash::check($request->oldPassword, $user->password)) {

            if($request->hasFile('avatar')){
                $upload = new Upload;
                $upload->file_original_name = null;
                $arr = explode('.', $request->file('avatar')->getClientOriginalName());

                for($i=0; $i < count($arr)-1; $i++){
                    if($i == 0){
                        $upload->file_original_name .= $arr[$i];
                    }
                    else{
                        $upload->file_original_name .= ".".$arr[$i];
                    }
                }

                $upload->file_name = $request->file('avatar')->store('uploads/all');
                $upload->user_id = $user->id;
                $upload->extension = $request->file('avatar')->getClientOriginalExtension();
                $upload->type = 'image';
                $upload->file_size = $request->file('avatar')->getSize();
                $upload->save();

                $user->update([
                    'avatar' => $upload->id,
                ]);
            }
            $user->update([
                'name' => $request->name,
                // 'phone' => $request->phone
            ]);

            if($request->password){
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
            }
            $user->save();

            return response()->json([
                'success' => true,
                'message' => translate('Profile information has been updated successfully'),
                'user' => new UserCollection($user)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => translate('The old password you have entered is incorrect')
            ]);
        }
    }
}

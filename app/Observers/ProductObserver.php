<?php

namespace App\Observers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductActionLog;
use Auth;
use Session;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Product  $product
     * @return void
     */

    // private $product;

    // public function __construct(Product $product){
    //     $this->product = $product;
    // }


    public function created(Product $product)
    {
            ProductActionLog::create([
                'product_name'=>$product->name,
                'product_id'=>$product->id,
                'user_id'=>Auth::user()->id,
                'user_name'=>Auth::user()->name,
                'action'=>'Create'
            ]);
            return 1;

    }

    public function updating(Product $product)
    {
        return 1;

    }


    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */


    public function updated(Product $product)
    {
        $request = request()->all();
        if(array_key_exists('user_id',$request)){
            return 1;
        }
        $old_object = $product->getOriginal();
        if(array_key_exists('product_update',$request)){

            $array_old = ["name","lowest_price","stock","description","discount","discount_type"];
            $array_new = ["name","price","stock","description","discount","discount_type"];
            $result_old = [];
            $result_new = [];

            foreach($array_old as  $value){

                if(in_array($value,$old_object)){
                    $result_old[$value] = $old_object[$value];
                }
            }

            foreach($array_new as  $value){
                if(isset($request[$value]))
                    $result_new[$value] = $request[$value];
            }

            $result=array_diff($result_new,$result_old);

        }


        if(Auth::check()){
            ProductActionLog::create([
                'product_name'=>$product->name,
                'product_id'=>$product->id,
                'user_id'=>Auth::user()->id,
                'user_name'=>Auth::user()->name,
                'action'=>'Update',
                'data_change' => !empty($result) ? json_encode($result) : null
            ]);
            return 1;
        }else{
            $temp_user_id = Session()->get('temp_user_id');
            ProductActionLog::create([
                'product_name'=>$product->name,
                'product_id'=>$product->id,
                'guest_id'=>$temp_user_id,
                'action'=>'Update',
                'data_change' => !empty($result) ? json_encode($result) : null

            ]);
            return 1;
        }
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        ProductActionLog::create([
            'product_name'=>$product->name,
            'product_id'=>$product->id,
            'user_id'=>Auth::user()->id,
            'user_name'=>Auth::user()->name,
            'action'=>'Delete'
        ]);
        return 1;
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}

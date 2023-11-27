<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferSingleCollection;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Models\Product;

use App\Models\Offer;
use Illuminate\Http\Request;




class OfferController extends Controller
{
    public function index()
    {
        return new OfferCollection(Offer::where('status',1)->where('start_date','<=',strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=',strtotime(date('d-m-Y H:i:s')))->latest()->get());
    }

    public function show($slug){
        $offer = Offer::with(['products.variations','products'=>function($query){
                    return $query->orderBy('serial_number','asc');
                }])->where('status',1)->where('start_date','<=',strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=',strtotime(date('d-m-Y H:i:s')))->where('slug',$slug)->first();


        if($offer){
            $categories=new CategoryCollection(\App\Models\Category::whereIn('id',(\App\Models\ProductCategory::whereIn('product_id',$offer->products->pluck('id'))->pluck('category_id')->toArray()))->get());
            $brands=\App\Models\Brand::whereIn('id',$offer->products->pluck('brand_id')->toArray())->get(['id','name','slug'])->toArray();
            // $products=new ProductCollection(\App\Models\Product::whereIn('id',$offer->products()->pluck('product_id')->toArray())->paginate(2));

            return new OfferSingleCollection(['offer'=>$offer,'cats'=>$categories,'brands'=>$brands]);
        }else{
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => translate('Offer not found!')
            ]);
        }
    }
    public function filter_offer(Request $request,$slug){

        $offer = Offer::where('status',1)->where('start_date','<=',strtotime(date('d-m-Y H:i:s')))->where('end_date', '>=',strtotime(date('d-m-Y H:i:s')))->where('slug',$slug)->first();
        if($offer){
            $offer_product_ids=$offer->products->pluck('id')->toArray();
            $query=Product::whereIn('id',$offer_product_ids);

            if($request->has('brand_ids') && $request->brand_ids!=null){
                $query->whereIn('brand_id',explode(",",$request->brand_ids));
            }
            if($request->has('min_price') && $request->has('max_price')){
                $query->where('lowest_price','>=',$request->min_price)->where('highest_price','<=',$request->max_price);
            }
            if($request->has('category_ids') && $request->category_ids!=null){

                $query->whereIn('products.id',\App\Models\ProductCategory::whereIn('category_id',explode(",",$request->category_ids))->pluck('product_id')->toArray());
            }
            return new ProductCollection(($query->paginate(20)));
        }else{
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => translate('Offer not found!')
            ]);
        }
    }

}

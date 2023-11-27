<?php

namespace App\Http\Controllers;

use App\Models\ProductActionLog;
use App\CombinedOrder;
use App\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductLogsExport;
use Excel;
class ProductActionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $date=$request->date;
        $type=null;

        $logs=ProductActionLog::query();

        if($request->button == 'export'){
            if($request->has('user_id') && $request->user_id!=null){

                $logs=$logs->where('user_id',$request->user_id);
            }
            if($date!=null){

                $logs=$logs->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));

            }
            if($request->has('product_name') && $request->product_name!=''){
                $product=Product::where('name',$request->product_name)->orWhere('name','LIKE', "%{$request->product_name}%")->first();
                if($product){
                    $logs=$logs->where('product_id',$product->id);
                }else{
                    flash(translate('No Product With This Name Found'))->error();
                }

            }
            if($request->has('type') && $request->type!=null){
                $type=$request->type;

                $logs=$logs->where('action',$request->type);
            }
            if($request->has('product_name') && $request->product_name!=''){
                $product=Product::where('name',$request->product_name)->orWhere('name','LIKE', "%{$request->product_name}%")->first();
                if($product){
                    $logs=$logs->where('product_id',$product->id);
                }else{
                    flash(translate('No Product With This Name Found'))->error();
                }

            }
            return Excel::download(new ProductLogsExport($logs->latest()->get()), 'product_action_log.xlsx');
        }
        if($request->has('user_id') && $request->user_id!=null){

            $logs=$logs->where('user_id',$request->user_id);
        }
        if($date!=null){

            $logs=$logs->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));

        }
        if($request->has('product_name') && $request->product_name!=''){
            $product=Product::where('name',$request->product_name)->orWhere('name','LIKE', "%{$request->product_name}%")->first();
            if($product){
                $logs=$logs->where('product_id',$product->id);
            }else{
                flash(translate('No Product With This Name Found'))->error();
            }

        }
        if($request->has('type') && $request->type!=null){
            $type=$request->type;

            $logs=$logs->where('action',$request->type);
        }

        $logs=$logs->orderBy('created_at','DESC')->paginate(13);
        $users=ProductActionLog::select('user_id')->distinct()->get();

        return view('backend.reports.product_action_log',compact('logs','type','date','users'));

    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductActionLog  $ProductActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(ProductActionLog $ProductActionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductActionLog  $ProductActionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductActionLog $ProductActionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductActionLog  $ProductActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductActionLog $ProductActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductActionLog  $ProductActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductActionLog $ProductActionLog)
    {
        //
    }
}

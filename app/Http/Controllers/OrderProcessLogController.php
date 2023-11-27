<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProcessLog;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderProcessLogExport;

class OrderProcessLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date=$request->date;

        $logs=OrderProcessLog::query();
        if($request->button == 'export'){
            $query=OrderProcessLog::query();

            if($request->has('user_id') && $request->user_id!=null){

                $query=$query->where('user_id',$request->user_id);
            }
            if($request->has('new_stat') && $request->new_stat!=null){

                $query=$query->where('new_stat',$request->new_stat);
            }
            if($date!=null){

                $query=$query->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));

            }
            if($request->has('order_code') && $request->order_code!=''){
                $order=Order::where('code', $request->order_code)->orWhere('code','LIKE', "{$request->order_code}%")->first();
                if($order){
                    $query=$query->whereIn('order_id',$order->id);
                }else{
                    flash(translate('No Order For This Code Found'))->error();
                }

            }

            return Excel::download(new OrderProcessLogExport($query->latest()->get()), 'order_process_log.xlsx');
        }
        if($request->has('user_id') && $request->user_id!=null){

            $logs=$logs->where('user_id',$request->user_id);
        }
        if($request->has('new_stat') && $request->new_stat!=null){

            $logs=$logs->where('new_stat',$request->new_stat);
        }
        if($date!=null){

            $logs=$logs->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));

        }
        if($request->has('order_code') && $request->order_code!=''){
            $order=Order::where('code', $request->order_code)->first();
            if($order){
                $logs=$logs->where('order_id',$order->id);
            }else{
                flash(translate('No Order For This Code Found'))->error();
            }

        }

        $logs=$logs->latest()->paginate(13);
        $users=OrderProcessLog::select('user_id')->distinct()->get();
        $new_stats=OrderProcessLog::select('new_stat')->distinct()->pluck('new_stat');
       //dd($new_stats);


        return view('backend.reports.order_process_logs',compact('logs','new_stats','date','users'));

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
     * @param  \App\OrderProcessLog  $OrderProcessLog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
// dd($request->order_id);
       $logs= OrderProcessLog::where('order_id',$request->order_id)->get();
// dd($logs);
      return response([ 'modal_view' => view('backend.partials.event_sidebar',compact('logs'))->render()]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderProcessLog  $OrderProcessLog
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderProcessLog $OrderProcessLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderProcessLog  $OrderProcessLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderProcessLog $OrderProcessLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderProcessLog  $OrderProcessLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderProcessLog $OrderProcessLog)
    {
        //
    }
}

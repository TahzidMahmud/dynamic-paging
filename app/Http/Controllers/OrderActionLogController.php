<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderActionLogExport;


class OrderActionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date=null;
        $type=null;
        $action=null;
        $q=new OrderActionLog();
        $users=[];
        $user=null;
        $res=DB::select('SELECT DISTINCT user_id from order_action_logs');
        foreach($res as $user){
            array_push($users,$user->user_id);
        }
        $users=User::whereIn('id',$users)->get();
        if($request->button == 'export'){
            $query = OrderActionLog::query();

            if($request->has('type') && $request->type!=null){
                $type=$request->type;

                $query=$query->where('type',$request->type);
            }
            if($request->has('action') && $request->action!=null){
                $action=$request->action;

                $query=$query->where('action',$request->action);
            }
            if($request->has('date') && $request->date!=null){
                $date=$request->date;
                $query=$query->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }
            if($request->has('order_code') && $request->order_code!=''){
                $order=Order::where('code', $request->order_code)->orWhere('code','LIKE', "{$request->order_code}%")->first();
                if($order){
                    $query=$query->where('order_id',$order->id);
                }else{
                    flash(translate('No Order Found'))->error();
                }

            }
            if($request->has('user') && $request->user!=null){
                // dd($request->user);

                $user=$request->user;
                $query=$query->whereIn('user_id',$request->user);
            }

            // dd($query);
            return Excel::download(new OrderActionLogExport($query->latest()->get()), 'order_action_log.xlsx');
        }


        if($request->has('user') && $request->user!=null){
            $user=$request->user;
            $q=$q->where('user_id',$request->user);
        }
        if($request->has('type') && $request->type!=null){
            $type=$request->type;

            $q=$q->where('type',$request->type);
        }
        if($request->has('action') && $request->action!=null){
            $action=$request->action;

            $q=$q->where('action',$request->action);
        }
        if($request->has('date') && $request->date!=null){
            $date=$request->date;
            $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if($request->has('order_code') && $request->order_code!=''){
            $order=Order::where('code', $request->order_code)->orWhere('code','LIKE', "%{$request->order_code}%")->first();
            if($order){
                $q=$q->where('order_id',$order->id);
            }else{
                flash(translate('No Order Found'))->error();
            }

        }
        $logs=$q->latest()->paginate('25');

        return view('backend.reports.order_action_logs',compact('date','logs','type', 'action', 'date','users','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}

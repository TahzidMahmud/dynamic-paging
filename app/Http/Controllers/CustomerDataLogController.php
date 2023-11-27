<?php

namespace App\Http\Controllers;

use App\Models\CustomerDataLog;
use Illuminate\Http\Request;
use App\Exports\CustomerDataLogsExport;
use App\Models\User;
use DB;
use Auth;
use Excel;
class CustomerDataLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date=null;
        $user=null;
        $users=[];
        $type=null;
        $q=new CustomerDataLog();

        $res=DB::select('SELECT DISTINCT user_id from customer_data_logs');
        if($request->button == 'export'){

            foreach($res as $user){
                array_push($users,$user->user_id);
            }
            $users=User::whereIn('id',$users)->get();

            if($request->has('user') && $request->user!=null){
                $user=$request->user;
                $q=$q->where('user_id',$request->user);
            }
            if($request->has('type') && $request->type!=null){
                $type=$request->type;

                $q=$q->where('action',$request->type);
            }
            if($request->has('date') && $request->date!=null){
                $date=$request->date;
                $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            return Excel::download(new CustomerDataLogsExport($q->latest()->get()), 'customer_data_logs.xlsx');
        }
        foreach($res as $user){
            array_push($users,$user->user_id);
        }
        $users=User::whereIn('id',$users)->get();

        if($request->has('user') && $request->user!=null){
            $user=$request->user;
            $q=$q->where('user_id',$request->user);
        }
        if($request->has('type') && $request->type!=null){
            $type=$request->type;

            $q=$q->where('action',$request->type);
        }
        if($request->has('date') && $request->date!=null){
            $date=$request->date;
            $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $logs=$q->latest()->paginate(25);
        return view('backend.reports.cutomer_data_action_logs',compact('date','type','users','logs'));
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
     * @param  \App\CustomerDataLog  $customerDataLog
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerDataLog $customerDataLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerDataLog  $customerDataLog
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerDataLog $customerDataLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerDataLog  $customerDataLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerDataLog $customerDataLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerDataLog  $customerDataLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerDataLog $customerDataLog)
    {
        //
    }
}

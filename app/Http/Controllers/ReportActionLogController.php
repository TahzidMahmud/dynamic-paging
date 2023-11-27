<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ReportActionLogsExport;
use App\Models\ReportActionLog;
use App\Models\User;
use DB;
use Auth;
use Excel;
class ReportActionLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date=null;
        $selected_user=null;
        $action_logs=[];
        $users=[];
        $type=null;
        $q=new ReportActionLog();

        $res=DB::select('SELECT DISTINCT user_id from report_action_logs');
        $action_log=DB::select('SELECT DISTINCT action_log from report_action_logs');

        foreach($res as $user){
            array_push($users,$user->user_id);
        }
        $users=User::whereIn('id',$users)->get();
        foreach($action_log as $log){
            array_push($action_logs,$log->action_log);
        }
        if($request->button == 'export'){



            if($request->has('user') && $request->user!=null){
                $selected_user=$request->user;
                $q=$q->where('user_id',$request->user);
            }
            if($request->has('type') && $request->type!=null){
                $type=$request->type;

                $q=$q->where('action',$request->type);
            }
            if($request->has('action_log') && $request->action_log!=null){
                $action_log=$request->action_log;

                $q=$q->where('action_log',$request->action_log);
            }
            if($request->has('date') && $request->date!=null){
                $date=$request->date;
                $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }


            return Excel::download(new ReportActionLogsExport($q->latest()->get()), 'report_action_logs.xlsx');
        }


        if($request->has('user') && $request->user!=null){
            $selected_user=$request->user;
            $q=$q->where('user_id',$request->user);
        }
        if($request->has('type') && $request->type!=null){
            $type=$request->type;

            $q=$q->where('action',$request->type);
        }
        if($request->has('action_log') && $request->action_log!=null){
            $action_log=$request->action_log;

            $q=$q->where('action_log',$request->action_log);
        }
        if($request->has('date') && $request->date!=null){
            $date=$request->date;
            $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }



        $logs=$q->latest()->paginate(25);
        return view('backend.reports.report_action_logs',compact('date','type','users','selected_user','logs','action_logs','action_log'));
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
     * @param  \App\ReportActionLog  $reportActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(ReportActionLog $reportActionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReportActionLog  $reportActionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ReportActionLog $reportActionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReportActionLog  $reportActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportActionLog $reportActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReportActionLog  $reportActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportActionLog $reportActionLog)
    {
        //
    }
}

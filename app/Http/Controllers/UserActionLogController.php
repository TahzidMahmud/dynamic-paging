<?php

namespace App\Http\Controllers;

use App\Exports\UserLogsExport;
use Illuminate\Http\Request;
use App\Models\UserActionLog;
use DB;
use App\Models\User;
use Excel;


class UserActionLogController extends Controller
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
        $q=new UserActionLog();

        $res=DB::select('SELECT DISTINCT user_id from user_action_logs');
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

            return Excel::download(new UserLogsExport($q->latest()->get()), 'user_action_log.xlsx');
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
        return view('backend.reports.user_action_log',compact('date','users','logs','type'));


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
     * @param  \App\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserActionLog $userActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserActionLog  $userActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserActionLog $userActionLog)
    {
        //
    }
}

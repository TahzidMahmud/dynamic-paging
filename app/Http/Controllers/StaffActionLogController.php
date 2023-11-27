<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\StaffActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StaffActionLogExport;

class StaffActionLogController extends Controller
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
        $staffs=[];
        $type=null;
        $q=new StaffActionLog();

        $res=DB::select('SELECT DISTINCT user_id, staff_id from staff_action_logs');
        if($request->button == 'export'){

            foreach($res as $user){
                array_push($users,$user->user_id);
                array_push($staffs,$user->staff_id);
            }
            $users=User::whereIn('id',$users)->get();
            $staffs=Staff::whereIn('id',$staffs)->get();
            if($request->has('user') && $request->user!=null){
                $user=$request->user;
                $q=$q->where('user_id',$request->user);
            }
            if($request->has('staff') && $request->staff!=null){
                $user=$request->staff;
                $q=$q->where('staff_id',$request->staff);
            }
            if($request->has('type') && $request->type!=null){
                $type=$request->type;

                $q=$q->where('action',$request->type);
            }
            if($request->has('date') && $request->date!=null){
                $date=$request->date;
                $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            return Excel::download(new StaffActionLogExport($q->latest()->get()), 'coupon_action_log.xlsx');
        }
        foreach($res as $user){
            array_push($users,$user->user_id);
            array_push($staffs,$user->staff_id);
        }
        $users=User::whereIn('id',$users)->get();
        $staffs=Staff::whereIn('id',$staffs)->get();
        if($request->has('user') && $request->user!=null){
            $user=$request->user;
            $q=$q->where('user_id',$request->user);
        }
        if($request->has('staff') && $request->staff!=null){
            $user=$request->staff;
            $q=$q->where('staff_id',$request->staff);
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
        return view('backend.reports.staff_action_logs',compact('date','type','users', 'staffs','logs'));
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
     * @param  \App\StaffActionLog  $staffActionLog
     * @return \Illuminate\Http\Response
     */
    public function show(StaffActionLog $staffActionLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StaffActionLog  $staffActionLog
     * @return \Illuminate\Http\Response
     */
    public function edit(StaffActionLog $staffActionLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StaffActionLog  $staffActionLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StaffActionLog $staffActionLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StaffActionLog  $staffActionLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(StaffActionLog $staffActionLog)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\HomePageEditLogsExport;
use App\Models\HomePageEditLog;
use App\Models\User;
use DB;
use Auth;
use Excel;
class HomePageEditLogController extends Controller
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
        $home_sections=[];
        $users=[];
        $type=null;
        $q=new HomePageEditLog();

        $res=DB::select('SELECT DISTINCT user_id from home_page_edit_logs');
        $home_section=DB::select('SELECT DISTINCT home_section from home_page_edit_logs');

        foreach($res as $user){
            array_push($users,$user->user_id);
        }
        $users=User::whereIn('id',$users)->get();
        foreach($home_section as $log){
            array_push($home_sections,$log->home_section);
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
            if($request->has('home_section') && $request->home_section!=null){
                $home_section=$request->home_section;

                $q=$q->where('home_section',$request->home_section);
            }
            if($request->has('date') && $request->date!=null){
                $date=$request->date;
                $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }


            return Excel::download(new HomePageEditLogsExport($q->latest()->get()), 'home_page_edit_logs.xlsx');
        }


        if($request->has('user') && $request->user!=null){
            $selected_user=$request->user;
            $q=$q->where('user_id',$request->user);
        }
        if($request->has('type') && $request->type!=null){
            $type=$request->type;

            $q=$q->where('action',$request->type);
        }
        if($request->has('home_section') && $request->home_section!=null){
            $home_section=$request->home_section;

            $q=$q->where('home_section',$request->home_section);
        }
        if($request->has('date') && $request->date!=null){
            $date=$request->date;
            $q=$q->whereDate('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }



        $logs=$q->latest()->paginate(25);
        return view('backend.reports.home_page_edit_logs',compact('date','type','users','selected_user','logs','home_sections','home_section'));
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
     * @param  \App\HomePageEditLog  $homePageEditLog
     * @return \Illuminate\Http\Response
     */
    public function show(HomePageEditLog $homePageEditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HomePageEditLog  $homePageEditLog
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePageEditLog $homePageEditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HomePageEditLog  $homePageEditLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePageEditLog $homePageEditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HomePageEditLog  $homePageEditLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomePageEditLog $homePageEditLog)
    {
        //
    }
}

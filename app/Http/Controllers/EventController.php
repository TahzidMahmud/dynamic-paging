<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use DB;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $events = Event::orderBy('created_at', 'asc');

        if ($request->search != null){
            $events = $events->where('name', 'like', '%'.$request->search.'%');
            $sort_search = $request->search;
        }

        $events = $events->paginate(15);

        return view('backend.event_system.event.index', compact('events','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.event_system.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $event = new Event;

        $event->name = $request->name;
        $event->banner = $request->banner;
        $event->description = $request->description;
        $event->images = json_encode($request->images);

        $event->save();

        flash(translate('Event has been created successfully'))->success();
        return redirect()->route('event.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $lang      = $request->lang;
        $event = Event::find($id);
        return view('backend.event_system.event.edit', compact('event','lang'));
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

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $event = Event::find($id);

        $event->name = $request->name;
        $event->banner = $request->banner;
        $event->description = $request->description;
        $event->images = json_encode($request->images);

        $event->save();

        flash(translate('Event has been updated successfully'))->success();
        return redirect()->route('event.index');
    }


    public function change_featured(Request $request) {
        // dd($request);
        $event = Event::find($request->id);
        $event->featured = $request->featured;
        $event->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Event::find($id)->delete();

        return redirect()->route('event.index');
    }
    public function event_video()
    {
        // dd('hit');
        return view('backend.event_system.video.store_video');
    }

}

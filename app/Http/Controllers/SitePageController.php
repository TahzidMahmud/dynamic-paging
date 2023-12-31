<?php

namespace App\Http\Controllers;

use App\Models\SitePage;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\PageItem;
use App\Models\PageItemAttribute;
class SitePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items=PageItem::with('attributes')->get();
        // $attributes=PageItemAttribute::all();

        // foreach($items as $item){
        //     $item->attributes()->attach($attributes[0]);
        //     $item->attributes()->attach($attributes[1]);
        // }
       return view('backend.pages.index',compact('items'));
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
     * @param  \App\Models\SitePage  $sitePage
     * @return \Illuminate\Http\Response
     */
    public function show(SitePage $sitePage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SitePage  $sitePage
     * @return \Illuminate\Http\Response
     */
    public function edit(SitePage $sitePage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SitePage  $sitePage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SitePage $sitePage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SitePage  $sitePage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SitePage $sitePage)
    {
        //
    }
}

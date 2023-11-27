<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $data = $request->form_data;

        $filtered_comment="";
        $filtered_name="";

        $filtered_name = preg_replace ("/[!\"`#'%&:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/"," ", $data['name']);
        $filtered_name = trim($filtered_name);

        $filtered_comment = preg_replace ("/[!\"`'%&:;<>=@{}~\$\(\)\*\+\/\\\?\[\]\^\|]+/"," ", $data['comment']);
        $filtered_comment = trim($filtered_comment);

        if($data['phone'] != null && strlen($data['phone'])==11 && preg_match ("/^[0-9]*$/", $data['phone'])){

            $phone = $data['phone'];
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Invalid Phone Number.'
            ]);
        }

        ContactUs::create([
            'name'=> $filtered_name,
            'comment'=> $filtered_comment,
            'phone'=> $phone,
            'email'=> $data['email']
        ]);

        return response()->json([
            'success' => true,
            'message' => translate('Your message has been received.')
        ]);
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

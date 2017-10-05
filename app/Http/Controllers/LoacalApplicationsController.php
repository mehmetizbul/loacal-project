<?php

namespace App\Http\Controllers;

use App\LoacalApplication;
use App\Role;
use Illuminate\Http\Request;

class LoacalApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aLa = LoacalApplication::where([
            ['accepted','=',0],
            ['rejected','=',0]
        ])->get();
        return view("user.applications", compact('aLa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.apply');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        LoacalApplication::create($request->all());
        return redirect('/my-account')->with('status', 'Thank you for applying to become a Loacal. We will get back to you shortly.');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        LoacalApplication::find($id)->setAcceptedAttribute();
        if($request->get('loacal_agent')){
            LoacalApplication::find($id)->user->attachRole('loacal_agent');
        }else {
            LoacalApplication::find($id)->user->attachRole('loacal_person');
        }

        return redirect()->route('loacal-applications.index')
            ->with('success','Application Accepted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LoacalApplication::find($id)->setRejectedAttribute();
        return redirect()->route('loacal-applications.index')
            ->with('success','Application Rejected');
    }

}

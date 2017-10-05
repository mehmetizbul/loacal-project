<?php

namespace App\Http\Controllers;

use App\OfflineExperience;
use Illuminate\Http\Request;
use App\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i=0;
        $countries = Country::whereParent(0)->orderBy('id','ASC')->paginate(5);
        $subs = [];
        $subs2 = [];
        foreach($countries as $oCount){
            $subs[$oCount->id] = Country::whereParent($oCount->id)->orderBy('id','ASC')->get();
            foreach($subs[$oCount->id] as $oSub){
                $subs2[$oSub->id] = Country::whereParent($oSub->id)->orderBy('id','ASC')->get();
            }
        }

        return view('countries.index',compact('countries','subs'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::get();
        $tmp = Country::whereParent(0)->orderBy('id','ASC')->get();

        $parents[0] = "-- This is the main country --";
        foreach($tmp as $oPar){
            $parents[$oPar->id] = $oPar->name;
        }

        return view('countries.create',compact('country','parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:countries,name',
            'slug' => 'required|unique:countries,slug',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $oCount = new Country();
        $oCount->name = $request->input('name');
        $oCount->slug = $request->input('slug');
        $oCount->parent = $request->input('parent');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Country::ICON_DIR,$file->getClientOriginalName());
            $oCount->icon = $file->getClientOriginalName();
        }
        $oCount->save();


        return redirect()->route('countries.index')
            ->with('success','Country created successfully');
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
    public function edit($id)
    {
        $country = Country::find($id);
        $tmp = Country::whereParent(0)->orderBy('id','ASC')->get();

        $parents[0] = "-- This is the main country --";
        foreach($tmp as $oPar){
            $parents[$oPar->id] = $oPar->name;
        }

        return view('countries.edit',compact('country','parents'));
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
        $rules = [
            'name' => 'required|unique:countries,name,'.$id.'',
            'slug' => 'required|unique:countries,slug,'.$id.'',
        ];

        $messages = [];

        $oCount = Country::find($id);
        $aCh = Country::whereParent($id)->get();
        if(count($aCh) && $oCount->parent != $request->input('parent')){
            $rules['existing_children'] = 'required';
            $messages['existing_children.required'] = "This country is already selected as parent country by a number of subcountries";
        }

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $oCount->name = $request->input('name');
        $oCount->slug = $request->input('slug');
        $oCount->parent = $request->input('parent');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Country::ICON_DIR,$file->getClientOriginalName());
            $oCount->icon = $file->getClientOriginalName();
        }
        $oCount->save();

        return redirect()->route('countries.index')
            ->with('success','Country updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aCh = Country::whereParent($id)->get();
        if(count($aCh)){
            $rules['existing_children'] = 'required';
            $messages['existing_children.required'] = "You cannot delete a country that is already selected as parent country by a number of subcountries";
            $validator = Validator::make([],$rules,$messages);
            if ($validator->fails()) return redirect()->back()->withErrors($validator);
        }

        DB::table("countries")->where('id',$id)->delete();
        return redirect()->route('countries.index')
            ->with('success','Country deleted successfully');
    }

    public function citycontainer(Request $request){
        $key=$request->get("key");
        $country = $request->get('country');
        $disable =$request->get("disable");

        return view('experience.partials.city',compact('key','country','disable'));
    }

    public function areacontainer(Request $request){
        $key=$request->get("key");
        $city = $request->get('city');
        $disable =$request->get("disable");

        return view('experience.partials.area',compact('key','city','disable'));
    }

    public function locationcontainer(Request $request){
        $key=$request->get("key");
        $disable =$request->get("disable");
        return view('experience.partials.location',compact('key','disable'));
    }
}

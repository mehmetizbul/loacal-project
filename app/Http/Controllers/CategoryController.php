<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function filter($category){
        dd(Category::whereSlug($category)->first()->experiences());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $i=0;
        $categories = Category::whereParent(0)->orderBy('id','ASC')->paginate(2);
        $subs = [];
        foreach($categories as $oCat){
            $subs[$oCat->id] = Category::whereParent($oCat->id)->orderBy('id','ASC')->get();
        }
        return view('categories.index',compact('categories','subs'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::get();
        $tmp = Category::whereParent(0)->orderBy('id','ASC')->get();

        $parents[0] = "-- This is the main category --";
        foreach($tmp as $oPar){
            $parents[$oPar->id] = $oPar->name;
        }

        return view('categories.create',compact('category','parents'));
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
            'name' => 'required|unique:categories,name',
            'slug' => 'required|unique:categories,slug',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $oCat = new Category();
        $oCat->name = $request->input('name');
        $oCat->slug = $request->input('slug');
        $oCat->parent = $request->input('parent');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Category::ICON_DIR,$file->getClientOriginalName());
            $oCat->icon = $file->getClientOriginalName();
        }
        $oCat->save();


        return redirect()->route('categories.index')
            ->with('success','Category created successfully');
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
        $category = Category::find($id);
        $tmp = Category::whereParent(0)->orderBy('id','ASC')->get();

        $parents[0] = "-- This is the main category --";
        foreach($tmp as $oPar){
            $parents[$oPar->id] = $oPar->name;
        }

        return view('categories.edit',compact('category','parents'));
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
            'name' => 'required|unique:categories,name,'.$id.'',
            'slug' => 'required|unique:categories,slug,'.$id.'',
        ];

        $messages = [];

        $oCat = Category::find($id);
        $aCh = Category::whereParent($id)->get();
        if(count($aCh) && $oCat->parent != $request->input('parent')){
            $rules['existing_children'] = 'required';
            $messages['existing_children.required'] = "This category is already selected as parent category by a number of subcategories";
        }

        $validator = Validator::make($request->all(), $rules,$messages);

        if ($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $oCat->name = $request->input('name');
        $oCat->slug = $request->input('slug');
        $oCat->parent = $request->input('parent');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Category::ICON_DIR,$file->getClientOriginalName());
            $oCat->icon = $file->getClientOriginalName();
        }
        $oCat->save();

        return redirect()->route('categories.index')
            ->with('success','Category updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aCh = Category::whereParent($id)->get();
        if(count($aCh)){
            $rules['existing_children'] = 'required';
            $messages['existing_children.required'] = "You cannot delete a category that is already selected as parent category by a number of subcategories";
            $validator = Validator::make([],$rules,$messages);
            if ($validator->fails()) return redirect()->back()->withErrors($validator);
        }

        DB::table("categories")->where('id',$id)->delete();
        return redirect()->route('categories.index')
            ->with('success','Category deleted successfully');
    }

    public function subs($id){
        $arr = Category::whereParent($id)->get();
        $ret = [];
        foreach($arr as $oCat){
            $tmp = $oCat->toArray();
            $tmp["icon"] = $oCat->icon();
            $ret[] = $tmp;
        }
        return json_encode($ret);
    }
}

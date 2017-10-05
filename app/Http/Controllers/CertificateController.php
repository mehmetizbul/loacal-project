<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    /**
     * Display a listing of the certificate.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $certificates = Certificate::orderBy('title','ASC')->paginate(10);

        return view('certificates.index',compact('certificates'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new certificate.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $certificate = Certificate::get();

        return view('certificates.create',compact('certificate'));
    }

    /**
     * Store a newly created certificate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:certificates,title',
        ]);

        $certificate = new Certificate();
        $certificate->title = $request->input('title');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Certificate::ICON_DIR,$file->getClientOriginalName());
            $certificate->icon = $file->getClientOriginalName();
        }
        $certificate->save();

        return redirect()->route('certificates.index')
            ->with('success','Certificate created successfully');
    }
    /**
     * Display the specified certificate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $certificate = Certificate::find($id);

        return view('certificates.show',compact('certificate'));
    }

    /**
     * Show the form for editing the specified certificate.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificate = Certificate::find($id);

        return view('certificates.edit',compact('certificate'));
    }

    /**
     * Update the specified certificate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:certificates,title,'.$id.'',
        ]);

        $certificate = Certificate::find($id);
        $certificate->title = $request->input('title');

        if( $request->hasFile('icon') ) {
            $file = $request->file('icon');
            $file->move(Certificate::ICON_DIR,$file->getClientOriginalName());
            $certificate->icon = $file->getClientOriginalName();
        }
        $certificate->save();

        return redirect()->route('certificates.index')
            ->with('success','Certificate updated successfully');
    }
    /**
     * Remove the specified certificate from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aRe = Certificate::find($id);
        if(count($aRe->experience_relations())){
            $rules['existing_experiences'] = 'required';
            $messages['existing_experiences.required'] = "You cannot delete a certificate that is being used by an Experience";
            $validator = Validator::make([],$rules,$messages);
            if ($validator->fails()) return redirect()->back()->withErrors($validator);
        }

        DB::table("certificates")->where('id',$id)->delete();
        return redirect()->route('certificates.index')
            ->with('success','Certificate deleted successfully');
    }
}
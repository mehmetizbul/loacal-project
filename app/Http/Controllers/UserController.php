<?php

namespace App\Http\Controllers;

use App\UserCertificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Hash;
use App\Certificate;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->get('role')){
            $role = $request->get('role');
            $data = User::whereHas(
                'roles', function ($q) use ($role){
                $q->whereId($role);
            }
            )->orderBy('name', 'ASC')->paginate(10);
        }else {
            $data = User::orderBy('name', 'ASC')->paginate(10);
            $role = $request->get('role') ? $request->input('role') : 0;
        }
        return view('user.index',compact('data'))
            ->with('selectedrole',$role);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('display_name','id');
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'slug' => 'required|unique:users,slug',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }

        $user->initProfile();


        return redirect('/users')
            ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('display_name','id');
        $userRole = $user->roles->pluck('id','id')->toArray();

        $certificates = Certificate::pluck('title','id');
        $userCertificates = $user->hasMany('App\UserCertificate')->pluck('certificate_id','certificate_id')->toArray();
        return view('user.edit',compact('user','roles','userRole','certificates','userCertificates'));
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

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'slug' => 'required|unique:users,slug,'.$id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();

        if(!isset($input['selfedit'])){
            $this->validate($request, [
                'roles' => 'required'
            ]);
        }

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        if( $request->hasFile('logo') ) {
            $file = $request->file('logo');
            $ext = ".".$file->getClientOriginalExtension();
            $file->move(User::getLogoDir(true),$user->id.$ext);
            $user->setLogo(User::getLogoDir(true).$user->id.$ext);
        }

        if(!isset($input['selfedit'])){
            //DB::table('role_user')->where('user_id', $id)->delete();
            $oUser = User::find($id);
            foreach($oUser->roles()->get() as $role){
                $oUser->detachRole($role);
            }
            if($request->input('roles')){
                $roles = $request->input('roles');
            }

            $min = min($roles);
            $max = 6;

            $roles[] = $max;


            for($i=$min;$i<=$max;$i++){
                $user->attachRole($i);
            }

            DB::table('user_certificates')->where('user_id', $id)->delete();
            if($request->input('certificates')) {
                foreach ($request->input('certificates') as $key => $value) {
                    UserCertificate::insert([
                        "user_id" => $user->id,
                        "certificate_id" => $value
                    ]);
                }
            }
        }else{
            return redirect('/my-account')
                ->with('success','Account updated successfully');
        }

        return redirect('/users/'.$user->id)
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('user.index')
            ->with('success','User deleted successfully');
    }
}
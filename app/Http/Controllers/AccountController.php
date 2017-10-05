<?php

namespace App\Http\Controllers;

use App\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account(){
        return view('user.account');
    }

    public function profile($slug){
        $oUser = User::whereSlug($slug)->first();
        return view('user.profile',compact('oUser'));
    }

    public function edit() {
        return view('user.accountedit');
    }
}

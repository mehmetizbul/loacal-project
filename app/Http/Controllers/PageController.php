<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function aboutus(){
        return view('loacal.aboutus');
    }
}

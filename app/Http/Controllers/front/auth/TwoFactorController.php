<?php

namespace App\Http\Controllers\front\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
        public function index(){
            $user= Auth::user();
            // dd($user->two_factor_secret);
            return view('front.auth.two-factor',compact('user'));
        }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    public function index(){
        return view('login', [
            
        ]);
    }

    public function manualLogin(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // dd("askjdgasjdf");

        if (Auth::attempt($credentials)) {
        
            return redirect()->intended('/gosite');
        }

        return redirect()->route('logins')->with('error', 'Email/Password salah');
    }


}

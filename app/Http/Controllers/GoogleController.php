<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoogleController extends Controller{

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(){
        try{
            $user = Socialite::driver('google')->user();
            // dd($user);
            $finduser = User::where('google_id', $user->getId())->first();
            // dd($finduser);
            if($finduser){
                Auth::login($finduser);
                return redirect()->intended('/gosite');
            }else{

                $newUser = User::create([
                    'name' => $user->name,
                    'username' => $user->email,
                    'email' =>$user->email,
                    'google_id'=> $user->id,
                    'password'=> bcrypt('12345678')
                ]);

                // $newUser = [
                //     'name' => $user->name,
                //     'username' => $user->email,
                //     'email' =>$user->email,
                //     'google_id'=> $user->id,
                //     'password'=> bcrypt('123')
                // ];

                // DB::table('users')->insert([
                //     'name' => $user->name,
                //     'username' => $user->email,
                //     'email' => $user->email,
                //     'google_id' => $user->id,
                //     'password' => bcrypt('123')
                // ]);

                Auth::login($newUser);
                return redirect()->intended('/gosite');

            }

        } catch (\Throwable $th) {

        }
    }

}

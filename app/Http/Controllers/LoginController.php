<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    public function enter(Request $request) {
        
        
        $user = User::where('email', $request->username)->where('password', md5($request->password))->first();
        
        if($user){

            Auth::loginUsingId($user->id);

            return redirect('/home');
        }
        
        return redirect('/login')->withInput();
    }
    
    public function logout() {
        
        Auth::logout();

        return redirect('/login');
    }
}

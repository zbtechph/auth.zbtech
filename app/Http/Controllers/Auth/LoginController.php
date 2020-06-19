<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showForm(){
        return view("auth.login-form");
    }
    
    public function authenticate(Request $req){
        
        $credentials = $req->validate([
            'email' => [ 'required','email:rfc' ],
            'password' => [ 'required', 'min:6' ]
        ]);
        
        //$credentials = $req->only('email', 'password');
        
        if(Auth::check() OR Auth::attempt($credentials)){
            // just return ok for now
            return "OK";
        } else {
            abort(403);
        }
    }
    
    public function logout(){
        if(Auth::check()){
            Auth::logout();
            return "OK";
        } else {
            abort(403);
        }
    }
    
}

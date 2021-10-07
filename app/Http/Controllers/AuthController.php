<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Hash;
use Session;
class AuthController extends Controller
{
    public function __construct()
    {
        if(Session::has('login'))
         {
             return redirect()->route('dashboard');
         }
    }
    public function logaut()
    {
        Session::forget('Login');

        return back();
    }
    public function login(Request $req)
    {
        $user = User::where('username', $req->username)->first();
        if($user == "")
        {
            $data = ['status'=>false, 'error'=>'User Not Found'];
        }
        else
        {
            if(Hash::check($req->password, $user->password))
            {
                $data = ['status'=>true, 'message'=>'Login Success'];
                Session::put('Login', $user);
            }
            else
            {
                $data = ['status'=>false, 'error'=>'Password Not Found'];
            }
        }
        
        return response()->json($data);
    }
}
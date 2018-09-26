<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index() 
    {
        return view('register'); 
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed', 
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
    
        return redirect()->route( 'login-form' );
    }
}

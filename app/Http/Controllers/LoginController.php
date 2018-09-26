<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Route;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout'] ] );
    }

    public function index() 
    {
        return view('login'); 
    }

    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'email'     => 'required|string|email',
            'password'  => 'required'
        ]);

        if ( Auth::attempt( ['email' => $request->email, 'password' => $request->password ] ) ) {
            // Success attempt to login user & redirect to user dashboard
            return redirect()->intended(route('user.dashboard'));
        } else {
            // Failed attempt to login either admin or dosen
            // Redirect back to login form
            return redirect()->back();
        }
      
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }
}

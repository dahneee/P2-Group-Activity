<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Session\Session as SessionSession;

class AuthManager extends Controller
{
    function login() {
        return view('login');
    }

    function signup() {
        return view('signup');
    }

    function loginPost(Request $request) {
        $request -> validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $validation = $request->only('email', 'password');
        if (Auth::attempt($validation)) {
            return redirect() -> intended(route('home'));
        }
        return redirect(route('login')) -> with("error", "Invalid Credentials");
    }

    function signupPost(Request $request){
        $request -> validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password'
        ]);

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);

        if(!$user) {
            return redirect(route('signup')) -> with("error", "Invalid Credentials");
        }
        return redirect(route('login')) -> with("success", "Signup Success");
    }

    function logout() {
        session()->flush();
        Auth::logout();
        return redirect(route('login'));
    }
}

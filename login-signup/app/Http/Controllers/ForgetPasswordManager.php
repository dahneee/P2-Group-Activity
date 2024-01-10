<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetPasswordManager extends Controller
{
    function forgetPassword(){
        return view('forget-password');
    }

    function forgetPasswordPost(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $token = Str::random(64);

        DB::table('password_resets') -> insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send("emails.forget-password", ['token' => $token], function($message) use ($request) {
            $message -> to($request -> email);
            $message -> subject("Reset Password");
        });

        return redirect() -> to(route('forget_password')) -> with("success", "Reset password link has been sent to your email.");

    }

    function resetPassword($token) {
        return view("new-password", compact('token'));
    }

    function resetPasswordPost(Request $request) {
        $request -> validate([
            'email' => 'email|required|exists:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);

        $updatePassword = DB::table('password_resets') -> where([
            'email' => $request -> email,
            'token' => $request -> token
        ]) -> first();

        if (!$updatePassword){
            return redirect() -> to(route('reset_password')) -> with('error', 'Invalid');
        }   

        User::where('email', $request->email) -> update(['password' => Hash::make($request->password)]);

        DB::table('password_resets') -> where(['email' => $request->email]) -> delete();

        return redirect() -> to(route('login')) -> with('success', 'Successfully reset password');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Auth;
class OTPController extends Controller
{
    public function loginwithoptpost(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email'=>'required|email|max:50'
        ]);
        $checkUser = User::where('email',$request->email)->first();
        if(is_null($checkUser)) {
            return redirect()->back()->with('error','Your email address is not associated with us.');
        } else {
            $otp = rand(100000,999999);
            $userUpdate = User::where('email',$request->email)->update([
                'otp' =>$otp,
            ]);

            Mail::send('emails.loginWithOTPEmail', ['otp'=>$otp], function ($message) use($request) {
                $message->to($request->email);
                $message->subject('Login with OTP - chirags.in');
            });
            return redirect()->route('confirm.login.with.otp')->with('success','Check your email inbox/spam folder for login with OTP code.');
        }
    }
    public function confirmloginwithoptpost(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email'=>'required|email|max:50',
            'otp'=>'required|numeric'
        ]);
        $checkUser = User::where('email',$request->email)->where('otp',$request->otp)->first();


        if(is_null($checkUser)) {
            return redirect()->back()->with('error','Your email address or OTP is incorrect.');
        } else {
            $userUpdate = User::where('email',$request->email)->update([
                'otp' =>null,
            ]);
            Auth::login($checkUser);
            return redirect()->route('home');
        }
    }
}

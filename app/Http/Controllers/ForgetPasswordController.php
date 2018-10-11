<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Reminder;
use Mail;   
use App\Mail\SendMail;
use Session;

 
class ForgetPasswordController extends Controller
{
    public function forgotpassword()
    {
    	return view('Auth.passwords.forgot-password');
    }
    public function postForgotPassword(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|max:255',
        ]);
        if ($request->email!="") 
        { 
            session(['email' => $request->email]);
            $this->send();
            return redirect()->back()->with('success',"Check your Email to reset password");
        }
        else
        {
            return redirect()->back()->with('alert','Check Your Credentials user not found.');
        }
    }
    public function send()
    {
        session(['key' => 'forgot']);
        Mail::send(new SendMail());
        return redirect()->back()->with('success',"Check your Email to reset password");
    }
}

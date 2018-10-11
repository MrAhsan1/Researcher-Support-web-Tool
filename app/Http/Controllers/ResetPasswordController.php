<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ResetPasswordController extends Controller
{
    public function resetpassword($token)
    {
    	return view('Auth.passwords.reset-password');
    }
    public function postResetPassword(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|max:255',
        ]);
        $user = User::where('email', $request->email)->first();
        if (count($user)>0) 
        {
        	$user->password = bcrypt($request->password);
        	$user->save();	
        	return redirect()->back()->with('success',"Your Password Successfully Reset");
        }
        else
        {
        	return redirect()->back()->with('alert','Check Your Credentials user Email not found.');
        }

    }
}

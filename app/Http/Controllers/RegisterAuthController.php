<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UsersActivations;
use Auth;
use Hash;
use App\Mail\VerifyMail;
use Mail;
use DB;

class RegisterAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('Auth.register');
    }
    public function register(Request $request)
    {
        $this->validation($request);
        $request['password'] = Hash::make($request->password);
        $input = $request->input('research_areas');
        $str = implode(',', $input);
        $user = new User();
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->email = $request['email'];
        $user->password = $request['password'];
        $user->research_areas = $str;
        $user->save();
        
        $verify = new UsersActivations();
        $verify->id_user = $user->id;
        $verify->token = str_random(40);
        $verify->save();

        Mail::to($user->email)->send(new VerifyMail($request,$verify));

        return redirect('/login')->with('success',"We have sent an activation code. Please check your mail.");
    }
    //Login
    public function showLoginForm()
    {
        return view('Auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request,[
        'email' => 'required|email|max:255',
        'password' => 'required|max:255',
        ]);
        
        $users = DB::table('users')->where('email',$request->email)->first();
        $pass = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        
        if(!is_null($users))
        {
            if ($pass===true) 
            { 
                if ($users->is_activated ==1 )
                {
                   if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) 
                    {
                         return redirect('/');
                    } 
                }
                else
                {
                    return redirect('/login')->with('Warning',"Your account is not activate check your mail.");
                }
            }
            else
            {
                return redirect()->back()->with('Warning',"Your Password is not correct.");
            }
        }
        else
        {
            return redirect()->back()->with('alert','Check Your Credentials user not found.');
        }
    }

    //End Login
    public function validation($request)
    {
        return $this->validate($request,[
        'fname' => 'required|max:255',
        'lname' => 'required|max:255',
        'email' => 'required|email|unique:users|max:255',
        'password' => 'required|min:6|confirmed|max:255',
        'research_areas' => 'required|max:255',
        ]);
    }
    //Email Verification
    public function userActivation($token)
    {
      $check = DB::table('users_activations')->where('token',$token)->first();
      if(!is_null($check)){
        $user = User::find($check->id_user);
        if ($user->is_activated == 1)
        {
          return redirect('/login')->with('success',"user are already actived.");
        }
        $user->update(['is_activated' => 1]);
        DB::table('users_activations')->where('token',$token)->delete();
        return redirect('/login')->with('success',"Your account is verified.");
      }
      return redirect('/login')->with('Warning',"your token is invalid");
    }
	
}

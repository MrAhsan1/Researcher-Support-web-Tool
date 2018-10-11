<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class ProfileController extends Controller
{
	public function update(Request $request) 
	{
  	/**
     * fetching the user model
     */
    	$user = Auth::user();

    /**
     * Validate request/input 
     **/
	    $this->validate($request, [
	        'fname' => 'required',
	        'lname' => 'required',
	        'email' => 'required|email|max:255|unique:users,email,'.$user->id,
	    ]);

	    $user = User::find($user->id);

	    $user->fname = $request->get('fname');    
	    $user->lname = $request->get('lname');
	    $user->email = $request->get('email');
	    

	    $newPass = $request->get('newPassword');
		$confirmPass = $request->get('confirmPassword');
	    $oldPass = $request->get('oldPassword');
	    if($oldPass != "")
	    {
		    if(Hash::check($oldPass, $user->password))
		    {
		    	if($newPass != "" || $confirmPass != "")
		    	{
			    	if($newPass == $confirmPass)
			    	{
			    		$user->password = bcrypt($newPass);
			    	}
			    	else
			    	{
			    		$message1 = "New Password can't match";
			    		return redirect('/profile')->with('message1', $message1);
			    	}
		    	}
		    	else
		    	{
		    		$message3 = "New Password can't be empty";
			    	return redirect('/profile')->with('message3', $message3);
		    	}
		    }
		    else
		    {
		    	$message2 = "Old Password can't match";
		    	return redirect('/profile')->with('message2', $message2);
		    }
		}
		elseif ($oldPass == "") 
		{
			if($newPass != "" || $confirmPass != "")
			{
				$message4 = "First enter old Password";
				return redirect('/profile')->with('message4', $message4);
			}
		}

	    $checkbutton = $request->get('notify');
	    if($checkbutton != null)
	    {
	    	$user->status = "On";
	    }
	    else
	    {
	    	$user->status = "";
	    }

	    if (count($request->get('research_areas'))==0)
	    {
	    	$user1 = Auth::user();
	    	$user->research_areas = $user1->research_areas;

	    }
	    else
	    {
	    	$user->research_areas = implode(',', $request->get('research_areas'));
	    }
	    $user->save();

	    return redirect('/profile')->with('message', 'User has been updated!');
	}
}
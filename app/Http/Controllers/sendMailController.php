<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

class sendMailController extends Controller
{
    public function send()
    {
    	session(['key' => 'mail']);
    	Mail::send(new SendMail());
    	return redirect()->back()->with('success',"Your message has been successfully received.");
    }
}

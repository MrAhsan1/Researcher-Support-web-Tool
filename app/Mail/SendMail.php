<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\request;
use Session;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {

        if(session('key')=="forgot")
        {
            $link = str_random(30);
            session(['token' => $link]);
            return $this->view('emails.password-reset',['token'=>$link])->to(session('email'));
        }
        elseif(session('key')=='mail')
        {
            
            return $this->view('emails.mail',['msg1'=>$request->message,'names1'=>$request->name,'q1'=>$request->query1,'email1'=>$request->email])->to('mrperfectahsan2015@gmail.com');
        }
    }
}

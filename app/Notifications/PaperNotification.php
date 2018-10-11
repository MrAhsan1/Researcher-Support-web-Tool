<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use DB;

class PaperNotification extends Notification
{
    use Queueable;

    public $paper;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($paper)
    {
        $this->paper = $paper;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $id = DB::table('notifications')->select('id')->orderby('created_at','desc')->first();
        foreach ($id as $key) 
        {
            $uid = $key;
        }
        return (new MailMessage)
                    ->line($this->paper->title)
                    ->action('Notification Action', url('/show/papers',[$this->paper->id,$uid]))
                    ->line('Thank you for using our application!');
    }
 
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {

        return [
            'data' => [
                'id' =>$this->paper->id,
                'title' =>$this->paper->title,
                'link' =>$this->paper->paperlinks,
                'date' =>$this->paper->dates,
                'abstract' =>$this->paper->abstract,
            ]
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $event, $message, $inviting, $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $event, $message)
    {
        $this->user = $user;
        $this->event = $event;
        $this->message = $message;
        $this->inviting = \Auth::user();
        $this->url = route('events.show', [$event->id, $event->slug]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.invitation');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyDriverMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailDataDriver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailDataDriver)
    {
        $this->mailDataDriver = $mailDataDriver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.notifydriver');
    }
}

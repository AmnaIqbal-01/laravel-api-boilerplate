<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use esources\views\emails;

class SendMail extends Mailable
{
    public $name;
    public $messageBody; // Add a property for the message body
    public $subject;
    public $view;

    public function __construct($name, $messageBody, $subject, $view)
    {
        $this->name = $name;
        $this->messageBody = $messageBody; // Set the message body property
        $this->subject = $subject;
        $this->view = $view;
    }

    public function build()
    {
        return $this
            ->subject($this->subject)
            ->view($this->view); // Use a Blade template for email content
    }
}

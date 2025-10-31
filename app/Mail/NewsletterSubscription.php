<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $type;

    public function __construct($email, $type = 'new')
    {
        $this->email = $email;
        $this->type = $type;
    }

    public function build()
    {
        $subject = $this->type === 'new' 
            ? 'Welcome to RALankaProperty Newsletter!'
            : 'Welcome back to RALankaProperty Newsletter!';

        return $this->subject($subject)
                    ->view('emails.newsletter-subscription')
                    ->with([
                        'email' => $this->email,
                        'type' => $this->type
                    ]);
    }
}
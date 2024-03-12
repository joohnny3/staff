<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public $recipient, public $carbonCopy, public $blindCarbonCopy, public $subject, public $content, public $template, public $attachment)
    {
    }

    public function build()
    {
        $email = $this->view('emails.' . $this->template)
            ->subject($this->subject)
            ->cc($this->carbonCopy)
            ->bcc($this->blindCarbonCopy)
            ->with([
                'content' => $this->content,
            ]);

        if ($this->attachment) {
            foreach ($this->attachment as $file)
                $email->attach(storage_path('app/' . $file));
        }

        return $email;
    }
}

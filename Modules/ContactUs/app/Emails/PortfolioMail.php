<?php

namespace Modules\ContactUs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PortfolioMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $userMail)
    {
        //
    }

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject("Portfolio Mail")->markdown(
            "contactus::mail.portfolio",
            [
                "userMail" => $this->userMail,
            ]
        );
    }
}

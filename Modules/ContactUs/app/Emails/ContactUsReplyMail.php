<?php

namespace Modules\ContactUs\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Envelope;
use Modules\ContactUs\Models\ContactUsMessage;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;

class ContactUsReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public ContactUsMessage $message,
        public string $replyMessage
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->message->email, $this->message->name),
            subject: "Re: {$this->message->subject}"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(markdown: "contactus::emails.reply");
    }
}

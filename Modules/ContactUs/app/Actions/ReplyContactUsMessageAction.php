<?php

namespace Modules\ContactUs\Actions;

use Illuminate\Support\Facades\Mail;
use Modules\ContactUs\Emails\ContactUsReplyMail;
use Modules\ContactUs\Models\ContactUsMessage;
use Modules\Core\Traits\HasActionHelpers;

class ReplyContactUsMessageAction
{
    use HasActionHelpers;

    public function handle(
        ContactUsMessage $contactUsMessage,
        string $replyMessage
    ) {
        Mail::to($contactUsMessage->email)->send(
            new ContactUsReplyMail($contactUsMessage, $replyMessage)
        );

        $contactUsMessage->update([
            "reply" => $replyMessage,
            "replied_at" => now(),
        ]);
    }
}

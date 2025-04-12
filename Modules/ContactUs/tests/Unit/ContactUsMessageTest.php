<?php

use Illuminate\Support\Facades\Mail;
use Modules\ContactUs\Actions\ReplyContactUsMessageAction;
use Modules\ContactUs\Emails\ContactUsReplyMail;
use Modules\ContactUs\Models\ContactUsMessage;

it("sends_reply_mail", function () {
    $message = ContactUsMessage::factory()->create();

    Mail::fake();

    Mail::assertNothingSent();

    ReplyContactUsMessageAction::new()->handle(
        $message,
        $replyMessage = fake()->sentence()
    );

    Mail::assertQueued(ContactUsReplyMail::class);

    expect($message->refresh()->replied_at)->not->toBeNull();
    expect($message->refresh()->reply)->toBe($replyMessage);
});

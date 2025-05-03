<?php

namespace Modules\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeGuestPasswordNotification extends Notification implements
    ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ["mail", "database"];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__("users::t.mail.guest_password_subject"))
            ->greeting(
                __("users::t.mail.guest_password_greeting", [
                    "name" => $notifiable->name,
                ])
            )
            ->line(__("users::t.mail.guest_password_line1"))
            ->line(__("users::t.mail.guest_password_line2"))
            ->action(
                __("users::t.mail.reset_password_button"),
                frontUrl("forget-password")
            )
            ->line(__("users::t.mail.signature") . ", " . config("app.name"));
    }

    /**
     * Get the array representation of the notification for the database.
     */
    public function toArray($notifiable): array
    {
        return [
            "title" => __("users::t.mail.guest_password_subject"),
            "message" => __("users::t.mail.guest_password_line1"),
            "action_url" => frontUrl("forget-password"),
        ];
    }
}

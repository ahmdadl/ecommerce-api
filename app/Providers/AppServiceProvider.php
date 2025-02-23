<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // @phpstan-ignore-next-line
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            // @phpstan-ignore-next-line
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}

<x-mail::message>
    # {{ __('contactus::t.reply_to_message') }}

    <x-mail::panel>
        Message on portfolio from {{ $userMail }}
    </x-mail::panel>



    {{ __('contactus::t.thanks') }}
    {{ config('app.name') }}
</x-mail::message>

<x-mail::message>
    # {{ __('contactus::t.reply_to_message') }}

    {{ $replyMessage }}

    <x-mail::button :url="config('app.frontend_url')">
        {{ __('contactus::t.visit_website') }}
    </x-mail::button>

    {{ __('contactus::t.thanks') }}<br>
    {{ config('app.name') }}
</x-mail::message>

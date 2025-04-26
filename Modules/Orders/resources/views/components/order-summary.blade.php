@props(['order', 'orderStatus', 'paymentStatus'])

@php
    use Modules\Orders\Enums\OrderStatus;
    use Modules\Orders\Enums\OrderPaymentStatus;
@endphp

<x-filament::card>
    <div class="flex justify-between items-start flex-wrap">
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                {{ __('orders::t.orderId', ['id' => $order->id]) }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.placedOn', [
                    'date' => \Carbon\Carbon::parse($order->created_at)->format('D d M Y \a\t h:i A'),
                ]) }}
            </p>
        </div>

        <div class="flex space-x-4 ">
            <x-filament::badge :color="OrderStatus::from($orderStatus)->color()" class="me-2">
                {{ __('orders::t.status_word') . ': ' }}
                {{ __('orders::t.status.' . $orderStatus) }}
            </x-filament::badge>
            <x-filament::badge :color="OrderPaymentStatus::from($paymentStatus)->color()">
                {{ __('orders::t.payment_status_word') . ': ' }}
                {{ __('orders::t.payment_status.' . $paymentStatus) }}
            </x-filament::badge>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="space-y-2">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ __('orders::t.customer') }}
            </h3>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $order->user?->name ?? __('orders::t.unknown') }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $order->user?->email ?? __('orders::t.unknown') }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $order->user?->phone ?? __('orders::t.unknown') }}
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ __('orders::t.shippingAddress') }}
            </h3>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $order->shippingAddress?->name ?? __('orders::t.unknown') }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $order->shippingAddress?->address ?? __('orders::t.unknown') }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $order->shippingAddress?->phone ?? __('orders::t.unknown') }}
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">
                {{ __('orders::t.paymentMethod') }}
            </h3>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $order->paymentMethodRecord?->name ?? __('orders::t.unknown') }}
            </p>
        </div>
    </div>
</x-filament::card>

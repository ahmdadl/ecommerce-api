@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.orderSummary') }}
    </h3>

    <div class="space-y-3">
        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.original') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->original ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.discount') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->discount ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.taxes') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->taxes ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.products') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $order->totals->products ?? 0 }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.items') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $order->totals->items ?? 0 }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.subtotal') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->subtotal ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.coupon') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->coupon ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('orders::t.shipping') }}
            </span>
            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->shipping ?? 0, 2) }} EGP
            </span>
        </div>

        <div class="flex justify-between border-t border-gray-200 dark:border-gray-700 pt-3 mt-3">
            <span class="text-base font-medium text-gray-900 dark:text-gray-100">
                {{ __('orders::t.total') }}
            </span>
            <span class="text-base font-bold text-gray-900 dark:text-gray-100">
                {{ number_format($order->totals->total ?? 0, 2) }} EGP
            </span>
        </div>
    </div>
</x-filament::card>

@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.orderSummary') }}
    </h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <tbody>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.original') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->original ?? 0, 2) }} EGP
                    </td>
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.discount') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->discount ?? 0, 2) }} EGP
                    </td>
                </tr>

                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.taxes') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->taxes ?? 0, 2) }} EGP
                    </td>
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.products') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ $order->totals->products ?? 0 }}
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.items') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ $order->totals->items ?? 0 }}
                    </td>
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.subtotal') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->subtotal ?? 0, 2) }} EGP
                    </td>
                </tr>
                <tr class="border-b border-gray-200 dark:border-gray-700">
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.coupon') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->coupon ?? 0, 2) }} EGP
                    </td>
                    <td class="py-2 text-gray-500 dark:text-gray-400">
                        {{ __('orders::t.shipping') }}
                    </td>
                    <td class="py-2 font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->shipping ?? 0, 2) }} EGP
                    </td>
                </tr>
                <tr class="border-t border-gray-200 dark:border-gray-700 pt-3">
                    <td class="py-2 text-base font-medium text-gray-900 dark:text-gray-100">
                        {{ __('orders::t.total') }}
                    </td>
                    <td class="py-2 text-base font-bold text-gray-900 dark:text-gray-100">
                        {{ number_format($order->totals->total ?? 0, 2) }} EGP
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
</x-filament::card>

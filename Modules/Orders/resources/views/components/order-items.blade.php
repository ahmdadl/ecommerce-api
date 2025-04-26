@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.orderItems') }}
    </h3>

    <div class="space-y-4">
        @foreach ($order->items ?? [] as $item)
            <div class="flex items-start border-b border-gray-200 dark:border-gray-700 pb-4">
                <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                    <div class="h-full w-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <div class="ml-4 flex-1">
                    <div class="flex justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $item->title ?? __('orders::t.unknown') }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('orders::t.sku', ['sku' => $item->sku ?? 'N/A']) }}
                            </p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            {{ number_format($item->totals->total ?? 0, 2) }} EGP
                        </p>
                    </div>

                    <div class="mt-2 flex justify-between">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('orders::t.quantity', ['quantity' => $item->quantity ?? 0]) }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ number_format(($item->totals->total ?? 0) / ($item->quantity ?: 1), 2) }}
                            EGP {{ __('orders::t.each') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-filament::card>

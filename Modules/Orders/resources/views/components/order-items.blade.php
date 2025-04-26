@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.orderItems') }}
    </h3>

    <div class="space-y-4">
        @foreach ($order->items ?? [] as $item)
            <div class="flex items-start border-b border-gray-200 dark:border-gray-700 pb-4">
                <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden">
                    @php
                        $item->loadMissing('product');
                    @endphp
                    <img src="{{ $item->product->images[0] ?? '' }}" alt="{{ $item->product->title ?? '' }}"
                        class="object-cover max-w-full" />
                </div>

                <div class="ml-4
                        flex-1">
                    <div class="flex justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $item->product->title ?? __('orders::t.unknown') }}
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('orders::t.sku', ['sku' => $item->product->sku ?? 'N/A']) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ number_format($item->totals->total ?? 0, 2) }} EGP
                            </p>
                            @if ($item->totals->subtotal !== $item->totals->total)
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-through">
                                    {{ number_format($item->totals->subtotal, 2) }} EGP
                                </p>
                            @endif
                        </div>
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

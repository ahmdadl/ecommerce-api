@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.paymentAttempts') }}
    </h3>

    <div class="fi-ta-overflow overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('ID') }}
                            </span>
                        </div>
                    </th>
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('Method') }}
                            </span>
                        </div>
                    </th>
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('Status') }}
                            </span>
                        </div>
                    </th>
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('Receipt') }}
                            </span>
                        </div>
                    </th>
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('Details') }}
                            </span>
                        </div>
                    </th>
                    <th class="fi-ta-header-cell p-0">
                        <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                            <span class="fi-ta-header-cell-label font-semibold">
                                {{ __('Date') }}
                            </span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($order->paymentAttempts as $attempt)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <!-- ID Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">
                                    <x-orders::copy :content="$attempt->id" limit="5" />
                                </span>
                            </div>
                        </td>

                        <!-- Method Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <x-filament::badge color="success" size="sm" class="fi-ta-badge">
                                    {{ $attempt->paymentMethodRecord->name }}
                                </x-filament::badge>
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <x-filament::badge :color="$attempt->status->color() ?? 'gray'" size="sm" class="fi-ta-badge">
                                    {{ __('orders::t.payment_status.' . $attempt->status->value) }}
                                </x-filament::badge>
                            </div>
                        </td>

                        <!-- Receipt Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                @if ($attempt->receipt)
                                    <x-filament::button color="success" size="sm" icon="heroicon-o-arrow-down-tray"
                                        tag="a" href="{{ $attempt->receipt }}" target="_blank">
                                    </x-filament::button>
                                @endif
                            </div>
                        </td>

                        <!-- Details Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <x-filament::modal>
                                    <x-slot name="trigger">
                                        <x-filament::button icon="heroicon-o-information-circle" size="sm"
                                            :disabled="empty($attempt->payment_details)">
                                        </x-filament::button>
                                    </x-slot>

                                    <x-filament::modal.heading>
                                        {{ __('Payment Details') }}
                                    </x-filament::modal.heading>

                                    <div class="fi-modal-content p-4">
                                        <div class="fi-ta-overflow overflow-x-auto">
                                            <table class="fi-ta-table w-full">
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach ($attempt->payment_details ?? [] as $detail)
                                                        <tr>
                                                            <td
                                                                class="fi-ta-cell p-3 text-sm text-gray-500 dark:text-gray-400">
                                                                {{ $detail[0] }}
                                                            </td>
                                                            <td
                                                                class="fi-ta-cell p-3 text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $detail[1] }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </x-filament::modal>
                            </div>
                        </td>

                        <!-- Date Column -->
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $attempt->created_at->format('D d M Y \a\t h:i A') }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::card>

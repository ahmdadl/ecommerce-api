@props(['order'])

@php
    use Modules\Orders\Enums\OrderStatusLogType;
@endphp

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.status_log') }}
    </h3>

    <div class="fi-ta-overflow overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 max-h-96">
        <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr class="text-sm leading-6 text-gray-500 dark:text-gray-400">
                    @foreach ([__('type'), __('orders::t.status_word'), __('orders::t.updatedBy'), __('orders::t.date'), __('orders::t.notes')] as $key)
                        <th class="fi-ta-header-cell p-0">
                            <div class="fi-ta-header-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="fi-ta-header-cell-label flex-1 truncate font-semibold">
                                    {{ $key }}
                                </span>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-gray-700">
                @php
                    $order->loadMissing('statusLogs.user');
                @endphp

                @foreach ($order->statusLogs as $status)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex w-fit items-center gap-x-2 p-3">
                                <x-filament::badge :color="$status->type->color() ?? 'gray'" size="sm" class="fi-ta-badge">
                                    {{ __('orders::t.status_log_type.' . $status->type->value) }}
                                </x-filament::badge>
                            </div>
                        </td>

                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex w-fit items-center gap-x-2 p-3">
                                @if ($status->type === OrderStatusLogType::ORDER)
                                    <x-filament::badge :color="$status->status->color() ?? 'gray'" size="sm" class="fi-ta-badge">
                                        {{ __('orders::t.status.' . $status->status->value) }}
                                    </x-filament::badge>
                                @else
                                    <x-filament::badge :color="$status->status->color() ?? 'gray'" size="sm" class="fi-ta-badge">
                                        {{ __('orders::t.payment_status.' . $status->status->value) }}
                                    </x-filament::badge>
                                @endif
                            </div>
                        </td>

                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="text-sm text-gray-950 dark:text-gray-50">
                                    {{ $status->user->name }}
                                </span>
                            </div>
                        </td>

                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $status->created_at->format('D d M Y \a\t h:i A') }}
                                </span>
                            </div>
                        </td>

                        <td class="fi-ta-cell p-0 first-of-type:ps-3 last-of-type:pe-3">
                            <div class="fi-ta-cell-wrapper flex items-center gap-x-2 p-3">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $status->notes }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-filament::card>

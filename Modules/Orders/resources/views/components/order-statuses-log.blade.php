@props(['order'])

@php
    use Modules\Orders\Enums\OrderStatusLogType;
@endphp

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.status_log') }}
    </h3>

    <table class="w-full">
        <thead>
            <tr>
                @foreach ([__('type'), __('orders::t.status_word'), __('orders::t.updatedBy'), __('orders::t.date'), __('orders::t.notes')] as $key)
                    <th class="text-left text-sm font-medium text-gray-900 dark:text-gray-100">
                        {{ $key }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $order->loadMissing('statusLogs.user');
            @endphp
            @foreach ($order->statusLogs as $status)
                <tr>
                    <td class="text-sm text-gray-500 dark:text-gray-400 p-2">
                        <div class="w-fit">
                            <x-filament::badge :color="$status->type->color() ?? 'gray'">
                                {{ __('orders::t.status_log_type.' . $status->type->value) }}
                            </x-filament::badge>
                        </div>
                    </td>
                    <td class="text-sm text-gray-500 dark:text-gray-400 p-2">
                        <div class="w-fit">
                            @if ($status->type === OrderStatusLogType::ORDER)
                                <x-filament::badge :color="$status->status->color() ?? 'gray'">
                                    {{ __('orders::t.status.' . $status->status->value) }}
                                </x-filament::badge>
                            @else
                                <x-filament::badge :color="$status->status->color() ?? 'gray'">
                                    {{ __('orders::t.payment_status.' . $status->status->value) }}
                                </x-filament::badge>
                            @endif
                        </div>
                    </td>
                    <td class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $status->user->name }}
                    </td>
                    <td class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $status->created_at->format('D d M Y \a\t h:i A') }}
                    </td>
                    <td class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $status->notes }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-filament::card>

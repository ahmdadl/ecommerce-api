@props(['order'])

<x-filament::card>
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
        {{ __('orders::t.paymentAttempts') }}
    </h3>

    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-md p-4">
        <div class="flex flex-row gap-3 justify-between">
            @foreach ($order->paymentAttempts as $attempt)
                <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                    #{{ str($attempt->id)->limit(5) }}
                </h4>

                <p>
                    <x-filament::badge color="success">
                        {{ $attempt->paymentMethodRecord->name }}
                    </x-filament::badge>
                </p>

                <p class="">
                    <x-filament::badge :color="$attempt->status->color() ?? 'gray'">
                        {{ __('orders::t.payment_status.' . $attempt->status->value) }}
                    </x-filament::badge>
                </p>



                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if ($attempt->receipt)
                        <x-filament::button color="success" class="text-sm" icon="heroicon-o-download"
                            href="{{ $attempt->receipt }}" target="_blank">
                            {{ __('orders::t.download_receipt') }}
                        </x-filament::button>
                    @endif

                </p>

                <x-filament::modal>
                    <x-slot name="trigger">
                        <x-filament::button icon="heroicon-o-information-circle" :disabled="empty($attempt->payment_details)">
                            {{--  --}}
                        </x-filament::button>
                    </x-slot>

                    <div class="p-4">
                        <table>
                            <tbody>
                                @foreach ($attempt->payment_details ?? [] as $detail)
                                    <tr>
                                        <td class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $detail[0] }}
                                        </td>
                                        <td class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $detail[1] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-filament::modal>

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $attempt->created_at->format('D d M Y \a\t h:i A') }}
                </p>
            @endforeach
        </div>
    </div>
</x-filament::card>

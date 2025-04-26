<x-filament-panels::page>
    <div class="space-y-6">
        @vite('resources/css/filament/admin/theme.css')

        <x-orders::order-summary :order="$order" :orderStatus="$orderStatus" :paymentStatus="$paymentStatus" />

        <div class="flex flex-row flex-wrap">
            <div class="w-full lg:w-2/3">
                <x-orders::order-payment-attempts :order="$order" />
            </div>

            <div class="w-full lg:w-1/3">
                <x-orders::order-totals :order="$order" />
            </div>
        </div>
    </div>

    <x-orders::order-items :order="$order" />
</x-filament-panels::page>

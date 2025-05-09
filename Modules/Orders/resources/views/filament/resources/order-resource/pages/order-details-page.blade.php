<x-filament-panels::page>
    <div class="space-y-6">
        @vite('resources/css/filament/admin/theme.css')

        <x-orders::order-summary :order="$order" :orderStatus="$orderStatus" :paymentStatus="$paymentStatus" />

        <x-orders::order-totals :order="$order" />
    </div>

    <x-orders::order-items :order="$order" />

    <x-orders::order-payment-attempts :order="$order" />

    <x-orders::order-statuses-log :order="$order" />
</x-filament-panels::page>

<?php

namespace Modules\Orders\Filament\Resources\OrderResource\Pages;

use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Modules\Orders\Filament\Resources\OrderResource;
use Filament\Resources\Pages\Page;
use Modules\Orders\Models\Order;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Orders\Models\PaymentAttempt;

class OrderDetailsPage extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = "orders::filament.resources.order-resource.pages.order-details-page";

    public Order $order;
    public ?string $orderStatus = null;
    public ?string $paymentStatus = null;

    public function mount(Order $record): void
    {
        $record->loadMissing([
            "user",
            "coupon",
            "shippingAddress",
            "paymentAttempts",
            "items.product",
        ]);

        $this->order = $record;

        $this->orderStatus = $this->order->status->value;
        $this->paymentStatus = $this->order->payment_status->value;
    }

    protected function getHeaderActions(): array
    {
        $statusOptions = [];
        foreach (OrderStatus::cases() as $status) {
            $statusOptions[$status->value] = __(
                "orders::t.status." . $status->value
            );
        }

        $paymentStatusOptions = [];
        foreach (OrderPaymentStatus::cases() as $status) {
            $paymentStatusOptions[$status->value] = __(
                "orders::t.payment_status." . $status->value
            );
        }

        return [
            Action::make("changeStatus")
                ->translateLabel()
                ->form([
                    Select::make("status")
                        ->translateLabel()
                        ->options($statusOptions)
                        ->default($this->order->status->value)
                        ->required(),

                    TextInput::make("notes")->translateLabel()->nullable(),
                ])
                ->action(function (array $data) {
                    $this->order->status = OrderStatus::from($data["status"]);
                    $this->order->save();

                    $this->orderStatus = $this->order->status->value;

                    Notification::make()
                        ->title(__("orders::t.status_updated_successfully"))
                        ->success()
                        ->send();
                }),

            Action::make("changePaymentStatus")
                ->translateLabel()
                ->color("danger")
                ->form([
                    Select::make("payment_status")
                        ->translateLabel()
                        ->options($paymentStatusOptions)
                        ->default($this->order->payment_status->value)
                        ->required(),

                    TextInput::make("notes")->translateLabel()->nullable(),
                ])
                ->action(function (array $data) {
                    $this->order->payment_status = OrderPaymentStatus::from(
                        $data["payment_status"]
                    );
                    $this->order->save();

                    $this->paymentStatus = $this->order->payment_status->value;

                    Notification::make()
                        ->title(
                            __("orders::t.payment_status_updated_successfully")
                        )
                        ->success()
                        ->send();
                }),
        ];
    }
}

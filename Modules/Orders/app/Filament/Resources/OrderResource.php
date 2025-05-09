<?php

namespace Modules\Orders\Filament\Resources;

use Modules\Orders\Filament\Resources\OrderResource\Pages;
use Modules\Orders\Filament\Resources\OrderResource\RelationManagers;
use Modules\Orders\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components as I;
use Filament\Tables\Columns as C;
use Filament\Tables\Filters as F;
use Filament\Tables\Actions as A;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Enums\FiltersLayout;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Orders\Enums\OrderStatus;
use Modules\Payments\Models\PaymentMethod;

class OrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = "heroicon-o-shopping-cart";

    public static function getNavigationGroup(): ?string
    {
        return __("Commerce");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["view", "change-status"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // no create or update
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                C\TextColumn::make("id")
                    ->translateLabel()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("user.name")
                    ->label(__("name"))
                    ->searchable(),
                C\TextColumn::make("user.email")
                    ->label(__("email"))
                    ->searchable()
                    ->limit(20)
                    ->toggleable(),
                C\TextColumn::make("user.phone")
                    ->label(__("phone"))
                    ->searchable()
                    ->toggleable(),
                C\TextColumn::make("payment_method")
                    ->searchable()
                    ->translateLabel()
                    ->formatStateUsing(
                        fn(string $state, Order $record): string => $record
                            ->payment_method_record->name
                    ),
                C\TextColumn::make("status")
                    ->translateLabel()
                    ->badge()
                    ->color(fn(OrderStatus $state): string => $state->color())
                    ->formatStateUsing(
                        fn(OrderStatus $state): string => __(
                            "orders::t.status.{$state->value}"
                        )
                    )
                    ->toggleable(),
                C\TextColumn::make("payment_status")
                    ->translateLabel()
                    ->badge()
                    ->color(
                        fn(OrderPaymentStatus $state): string => $state->color()
                    )
                    ->formatStateUsing(
                        fn(OrderPaymentStatus $state): string => __(
                            "orders::t.payment_status.{$state->value}"
                        )
                    )
                    ->toggleable(),
                C\TextColumn::make("totals.total")
                    ->money("EGP")
                    ->translateLabel(),
                C\TextColumn::make("totals.items")
                    ->numeric()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("coupon.code")
                    ->translateLabel()
                    ->searchable(),
                C\TextColumn::make("shippingAddress.address")
                    ->translateLabel()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->words(10),
                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTooltip(),
            ])
            ->filters(
                [
                    F\Filter::make("user.name")
                        ->translateLabel()
                        ->form([I\TextInput::make("value")->label(__("Name"))])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "user",
                                    fn($q) => $q->where(
                                        "name",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),
                    F\Filter::make("user.email")
                        ->translateLabel()
                        ->form([I\TextInput::make("value")->label(__("Email"))])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "user",
                                    fn($q) => $q->where(
                                        "email",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),
                    F\Filter::make("user.phone")
                        ->translateLabel()
                        ->form([
                            I\TextInput::make("value")->label(
                                __("Phone Number")
                            ),
                        ])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "user",
                                    fn($q) => $q->where(
                                        "phone",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),

                    F\SelectFilter::make("status")
                        ->translateLabel()
                        ->options(OrderStatus::class)
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->where("status", $data["value"])
                            )
                        ),

                    F\SelectFilter::make("payment_status")
                        ->translateLabel()
                        ->options(OrderPaymentStatus::class)
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->where(
                                    "payment_status",
                                    $data["value"]
                                )
                            )
                        ),

                    F\SelectFilter::make("payment_method")
                        ->translateLabel()
                        ->options(
                            fn() => PaymentMethod::all()
                                ->pluck("name", "id")
                                ->toArray()
                        )
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->where(
                                    "payment_method_id",
                                    $data["value"]
                                )
                            )
                        ),

                    F\Filter::make("coupon.code")
                        ->translateLabel()
                        ->form([
                            I\TextInput::make("value")->label(__("CouponCode")),
                        ])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "coupon",
                                    fn($q) => $q->where(
                                        "code",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),

                    F\Filter::make("shippingAddress.address")
                        ->translateLabel()
                        ->form([
                            I\TextInput::make("value")->label(__("address")),
                        ])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "shippingAddress",
                                    fn($q) => $q->where(
                                        "address",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),

                    F\Filter::make("created_at")
                        ->form([
                            DatePicker::make("created_from")->label(
                                __("Created From")
                            ),
                            DatePicker::make("created_until")->label(
                                __("Created Until")
                            ),
                        ])
                        ->query(function ($query, array $data) {
                            $query
                                ->when(
                                    $data["created_from"],
                                    fn($q) => $q->whereDate(
                                        "created_at",
                                        ">=",
                                        $data["created_from"]
                                    )
                                )
                                ->when(
                                    $data["created_until"],
                                    fn($q) => $q->whereDate(
                                        "created_at",
                                        "<=",
                                        $data["created_until"]
                                    )
                                );
                        }),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                A\ViewAction::make(),
                a\ReplicateAction::make()->hidden(app()->isProduction()),
            ])
            ->defaultSort("created_at", "desc");
    }

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(["user", "coupon", "shippingAddress", "paymentAttempts"])
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->orderByDesc("created_at");
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListOrders::route("/"),
            "view" => Pages\OrderDetailsPage::route("/{record}"),
        ];
    }
}

<?php

namespace Modules\Wallets\Filament\Resources;

use Modules\Wallets\Filament\Resources\WalletTransactionResource\Pages;
use Modules\Wallets\Filament\Resources\WalletTransactionResource\RelationManagers;
use Modules\Wallets\Models\WalletTransaction;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components as I;
use Filament\Tables\Columns as C;
use Filament\Tables\Filters as F;
use Filament\Tables\Actions as A;
use Filament\Infolists\Components as L;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Enums\FiltersLayout;
use Modules\Orders\Enums\OrderPaymentStatus;
use Modules\Payments\Models\PaymentAttempt;
use Modules\Payments\Models\PaymentMethod;
use Modules\Wallets\Enums\WalletTransactionStatus;
use Modules\Wallets\Enums\WalletTransactionType;

class WalletTransactionResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = WalletTransaction::class;

    protected static ?string $navigationIcon = "heroicon-o-receipt-percent";

    public static function getNavigationGroup(): ?string
    {
        return __("Wallets");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["change_wallet_transaction_status", "view_payment_attempts"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            //    no create or update
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
                C\TextColumn::make("wallet.id")
                    ->translateLabel()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("wallet.user.name")
                    ->label(__("User"))
                    ->searchable(),
                C\TextColumn::make("user.email")
                    ->label(__("email"))
                    ->searchable()
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("user.phone")
                    ->label(__("phone"))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("created_by")
                    ->translateLabel()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("amount")->numeric()->sortable(),
                C\TextColumn::make("type")
                    ->translateLabel()
                    ->badge()
                    ->color(
                        fn(
                            WalletTransactionType $state
                        ): string => $state->color()
                    )
                    ->formatStateUsing(
                        fn(WalletTransactionType $state): string => __(
                            "wallets::t.types.{$state->value}"
                        )
                    ),
                C\TextColumn::make("status")
                    ->translateLabel()
                    ->badge()
                    ->color(
                        fn(
                            WalletTransactionStatus $state
                        ): string => $state->color()
                    )
                    ->formatStateUsing(
                        fn(WalletTransactionStatus $state): string => __(
                            "wallets::t.transaction_statuses.{$state->value}"
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
                C\TextColumn::make("payment_method")
                    ->searchable()
                    ->translateLabel()
                    ->formatStateUsing(
                        fn(
                            string $state,
                            WalletTransaction $record
                        ): string => $record->payment_method_record->name
                    ),
                C\TextColumn::make("notes")->translateLabel()->searchable(),
                C\TextColumn::make("created_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("updated_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("deleted_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    F\Filter::make("wallet.user.name")
                        ->translateLabel()
                        ->form([I\TextInput::make("value")->label(__("Name"))])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "wallet.user",
                                    fn($q) => $q->where(
                                        "name",
                                        "like",
                                        "%" . $data["value"] . "%"
                                    )
                                )
                            )
                        ),
                    F\Filter::make("wallet.user.email")
                        ->translateLabel()
                        ->form([I\TextInput::make("value")->label(__("Email"))])
                        ->query(
                            fn($query, $data) => $query->when(
                                $data["value"],
                                fn($q) => $q->whereHas(
                                    "wallet.user",
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
                                    "wallet.user",
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
                        ->options(WalletTransactionStatus::class)
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
                            fn() => PaymentMethod::where(
                                "code",
                                "!=",
                                PaymentMethod::WALLET
                            )
                                ->get()
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

                    F\Filter::make("created_at")
                        ->form([
                            I\DatePicker::make(
                                "created_from"
                            )->translateLabel(),
                            I\DatePicker::make(
                                "created_until"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            if ($data["created_from"]) {
                                $query->whereDate(
                                    "created_at",
                                    ">=",
                                    $data["created_from"]
                                );
                            }
                            if ($data["created_until"]) {
                                $query->whereDate(
                                    "created_at",
                                    "<=",
                                    $data["created_until"]
                                );
                            }
                        })
                        ->columns(2)
                        ->indicateUsing(function (array $data): ?string {
                            $indicators = [];
                            if ($data["created_from"]) {
                                $indicators[] = "Created From: {$data["created_from"]}";
                            }
                            if ($data["created_until"]) {
                                $indicators[] = "Created Until: {$data["created_until"]}";
                            }
                            return !empty($indicators)
                                ? implode(", ", $indicators)
                                : null;
                        }),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                A\Action::make("view_payment_attempts")
                    ->label(__("Payments"))
                    ->icon("heroicon-o-viewfinder-circle")
                    ->color("info")
                    ->infolist([
                        L\Grid::make(2)->schema([
                            L\TextEntry::make("id")->translateLabel(),
                            L\TextEntry::make("payment_attempts_count")
                                ->translateLabel()
                                ->numeric(),
                        ]),

                        L\RepeatableEntry::make("paymentAttempts")
                            ->label(__("orders::t.paymentAttempts"))
                            ->schema([
                                L\TextEntry::make(
                                    "payment_method"
                                )->formatStateUsing(
                                    fn(
                                        string $state,
                                        PaymentAttempt $record
                                    ): string => $record->payment_method_record
                                        ->name
                                ),
                                L\TextEntry::make("status")
                                    ->badge()
                                    ->color(
                                        fn(
                                            OrderPaymentStatus $state
                                        ): string => $state->color()
                                    ),
                                L\TextEntry::make("receipt")->url(
                                    fn(
                                        PaymentAttempt $record
                                    ) => $record->receipt
                                ),
                            ])
                            ->columns(2),
                    ])
                    ->hidden(
                        user()->cannot(
                            "view_payment_attempts_wallet::transaction"
                        )
                    ),

                A\Action::make("change_status")
                    ->label(__("Status"))
                    ->icon("heroicon-o-arrows-right-left")
                    ->hidden(function (WalletTransaction $record): bool {
                        if (
                            $record->status !== WalletTransactionStatus::PENDING
                        ) {
                            return true;
                        }

                        return user()->cannot(
                            "change_wallet_transaction_status_wallet::transaction"
                        );
                    })
                    ->form([
                        I\Select::make("status")
                            ->translateLabel()
                            ->options(WalletTransactionStatus::class)
                            ->required(),
                    ])
                    ->action(function (
                        array $data,
                        WalletTransaction $record
                    ): void {
                        $record->status = $data["status"];
                        $record->save();
                    })
                    ->requiresConfirmation(),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with("wallet.user")
            ->withCount("paymentAttempts");
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListWalletTransactions::route("/"),
        ];
    }
}

<?php

namespace Modules\Wallets\Filament\Resources;

use Modules\Wallets\Filament\Resources\WalletResource\Pages;
use Modules\Wallets\Filament\Resources\WalletResource\RelationManagers;
use Modules\Wallets\Models\Wallet;
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
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Modules\Wallets\ValueObjects\WalletBalance;

class WalletResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = "heroicon-o-wallet";

    public static function getNavigationGroup(): ?string
    {
        return __("Wallets");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["create", "update", "credit", "debit"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            I\Select::make("user_id")->relationship("user", "name")->required(),

            I\Toggle::make("is_active")->translateLabel()->default(true),
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
                    ->label(__("User"))
                    ->searchable(),
                C\TextColumn::make("balance.available")
                    ->label(__("available_balance"))
                    ->money("EGP")
                    ->toggleable()
                    ->sortable(),
                C\TextColumn::make("balance.pending")
                    ->label(__("pending_balance"))
                    ->money("EGP")
                    ->toggleable()
                    ->sortable(),
                C\TextColumn::make("balance.total")
                    ->label(__("total_balance"))
                    ->money("EGP")
                    ->toggleable()
                    ->sortable(),
                C\TextColumn::make("transactions_count")
                    ->label(__("transactions_count"))
                    ->numeric()
                    ->badge()
                    ->toggleable()
                    ->sortable(),
                C\IconColumn::make("is_active")->translateLabel()->boolean(),
                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("deleted_at")
                    ->dateTime()
                    ->sortable()
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    SelectFilter::make("user_id")
                        ->relationship("user", "name")
                        ->searchable()
                        ->translateLabel(),

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
                    activeToggler(),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                A\EditAction::make()->iconButton(),
                A\Action::make("credit")
                    ->icon("heroicon-o-plus-circle")
                    ->translateLabel()
                    ->closeModalByClickingAway(false)
                    ->hidden(user()->cannot("credit_wallet"))
                    ->form([
                        I\TextInput::make("amount")
                            ->required()
                            ->translateLabel()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(10000),
                        I\TextInput::make("notes")
                            ->nullable()
                            ->translateLabel(),
                    ])
                    ->action(function (array $data, Wallet $record): void {
                        walletService(false, $record->user)->fullyCredit(
                            $data["amount"],
                            auth()->user(),
                            $data["notes"]
                        );
                    })
                    ->requiresConfirmation()
                    ->color("success"),
                A\Action::make("debit")
                    ->icon("heroicon-o-minus-circle")
                    ->translateLabel()
                    ->closeModalByClickingAway(false)
                    ->hidden(user()->cannot("debit_wallet"))
                    ->color("danger")
                    ->form([
                        I\TextInput::make("amount")
                            ->required()
                            ->translateLabel()
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(10000),
                        I\TextInput::make("notes")
                            ->nullable()
                            ->translateLabel(),
                    ])
                    ->action(function (array $data, Wallet $record): void {
                        walletService(false, $record->user)->fullyDebit(
                            $data["amount"],
                            auth()->user(),
                            $data["notes"]
                        );
                    })
                    ->requiresConfirmation(),
            ])
            ->defaultSort("created_at", "desc");
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount("transactions");
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListWallets::route("/"),
            "create" => Pages\CreateWallet::route("/create"),
            "edit" => Pages\EditWallet::route("/{record}/edit"),
        ];
    }
}

<?php

namespace Modules\Users\Filament\Resources;

use Filament\Forms\Components as F;
use Filament\Forms\Form;
use Filament\Infolists\Components as I;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns as T;
use Filament\Tables\Table;
use Modules\Users\Enums\UserGender;
use Modules\Users\Filament\Resources\CustomerResource\Pages;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            F\TextInput::make("name")->required()->maxLength(50),
            F\TextInput::make("email")->email()->required()->maxLength(100),
            F\TextInput::make("phoneNumber")
                ->translateLabel()
                ->nullable()
                ->maxLength(12),
            F\TextInput::make("password")
                ->password()
                ->revealable()
                ->required(fn($state, $record) => is_null($record->password))
                ->dehydrated(fn($state) => filled($state))
                ->maxLength(20)
                ->minLength(8)
                ->nullable(),
            F\Toggle::make("is_active")->translateLabel()->default(true),
            F\ToggleButtons::make("gender")
                ->enum(UserGender::class)
                ->options([
                    "male" => __(UserGender::MALE->value),
                    "female" => __(UserGender::FEMALE->value),
                ])
                ->nullable()
                ->inline(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                T\TextColumn::make("id")->translateLabel(),
                T\TextColumn::make("name")->translateLabel(),
                T\TextColumn::make("email")
                    ->translateLabel()
                    ->url(fn(User $record) => "mailto:{$record->email}"),
                T\TextColumn::make("phoneNumber")->translateLabel(),
                T\IconColumn::make("is_active")
                    ->translateLabel()
                    ->boolean()
                    ->label("Active"),
                T\TextColumn::make("gender")
                    ->translateLabel()
                    ->state(fn($record) => __($record->gender->value)),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->translateLabel(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            I\TextEntry::make("id")->translateLabel(),
            I\TextEntry::make("created_at")->label(__("joinedAt")),
            I\TextEntry::make("name")->translateLabel(),
            I\TextEntry::make("email")->translateLabel(),
            I\TextEntry::make("phoneNumber")->translateLabel(),
            I\IconEntry::make("is_active")->translateLabel()->boolean(),
            I\TextEntry::make("gender")
                ->translateLabel()
                ->state(fn($record) => __($record->gender->value)),
            I\KeyValueEntry::make("totals")->translateLabel(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCustomers::route("/"),
            "create" => Pages\CreateCustomer::route("/create"),
            "edit" => Pages\EditCustomer::route("/{record}/edit"),
        ];
    }
}

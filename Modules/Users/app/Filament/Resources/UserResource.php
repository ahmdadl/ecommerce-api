<?php

namespace Modules\Users\Filament\Resources;

use Filament\Forms\Components as F;
use Filament\Forms\Form;
use Filament\Infolists\Components as I;
use Filament\Tables\Columns as T;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Modules\Users\Enums\UserGender;
use Modules\Users\Filament\Resources\UserResource\Pages;
use Modules\Users\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    protected static bool $shouldRegisterNavigation = false;

    public static function userFormSchema(): array
    {
        return [
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
        ];
    }
    public static function userTableColumns(): array
    {
        return [
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
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(self::userFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::userTableColumns())
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            "index" => Pages\ListUsers::route("/"),
            "create" => Pages\CreateUser::route("/create"),
            "edit" => Pages\EditUser::route("/{record}/edit"),
        ];
    }
}

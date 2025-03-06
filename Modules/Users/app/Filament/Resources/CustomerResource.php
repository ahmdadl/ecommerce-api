<?php

namespace Modules\Users\Filament\Resources;

use Filament\Actions\Action;
use Filament\Forms\Components as F;
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                F\TextInput::make('name')->required()->maxLength(50),
                F\TextInput::make('email')->email()->required()->maxLength(100),
                F\TextInput::make('phoneNumber')->nullable()->maxLength(12),
                F\TextInput::make('password')->password()
                    ->required(fn($state, $record) => is_null($record->password))
                    ->dehydrated(fn($state) => filled($state))
                    ->maxLength(20)
                    ->minLength(8)
                    ->nullable(),
                F\Toggle::make('is_active')->label('Active')->default(true),
                F\ToggleButtons::make('gender')->enum(UserGender::class)->options([
                    'male' => UserGender::MALE->value,
                    'female' => UserGender::FEMALE->value,
                ])->nullable()->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                T\TextColumn::make('id'),
                T\TextColumn::make('name'),
                T\TextColumn::make('email')->url(fn(User $record) => "mailto:{$record->email}"),
                T\TextColumn::make('phoneNumber'),
                T\IconColumn::make('is_active')->boolean()->label('Active'),
                T\TextColumn::make('gender'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}

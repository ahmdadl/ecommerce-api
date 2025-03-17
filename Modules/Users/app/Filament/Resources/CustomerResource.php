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

    protected static ?string $navigationIcon = "heroicon-o-user-group";

    public static function form(Form $form): Form
    {
        return $form->schema(UserResource::userFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(UserResource::userTableColumns())
            ->filters(array_merge([], UserResource::userTableFilters()))
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
            I\TextEntry::make("phone")->translateLabel(),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->role(Customer::$role);
    }
}

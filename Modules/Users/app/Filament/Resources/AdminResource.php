<?php

namespace Modules\Users\Filament\Resources;

use Modules\Users\Filament\Resources\AdminResource\Pages;
use Modules\Users\Models\Admin;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Users\Models\User;
use Spatie\Permission\Models\Role;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = "heroicon-o-users";

    public static function form(Form $form): Form
    {
        return $form->schema([UserResource::userFormSchema()]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(UserResource::userTableColumns())
            ->filters(array_merge([], UserResource::userTableFilters()))
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\Action::make("select_role")
                    ->translateLabel()
                    ->icon("heroicon-o-lock-closed")
                    ->form([
                        Select::make("roleId")
                            ->label("Role")
                            ->options(Role::query()->pluck("name", "id"))
                            ->required(),
                    ])
                    ->action(function (array $data, User $record): void {
                        $record->assignRole((int) $data["roleId"]);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            "index" => Pages\ListAdmins::route("/"),
            "create" => Pages\CreateAdmin::route("/create"),
            "edit" => Pages\EditAdmin::route("/{record}/edit"),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->role(Admin::$role);
    }
}

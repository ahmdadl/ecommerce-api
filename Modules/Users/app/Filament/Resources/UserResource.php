<?php

namespace Modules\Users\Filament\Resources;

use Filament\Forms\Components as F;
use Filament\Forms\Form;
use Filament\Infolists\Components as I;
use Filament\Tables\Columns as T;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Enums\UserGender;
use Modules\Users\Enums\UserRole;
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
            T\TextColumn::make("id")->translateLabel()->toggleable(false),
            T\TextColumn::make("name")->translateLabel(),
            T\TextColumn::make("email")
                ->translateLabel()
                ->url(fn(User $record) => "mailto:{$record->email}"),
            T\TextColumn::make("phoneNumber")
                ->translateLabel()
                ->toggleable(true),
            T\IconColumn::make("is_active")
                ->translateLabel()
                ->boolean()
                ->label("Active"),
            T\TextColumn::make("gender")
                ->translateLabel()
                ->state(fn($record) => __($record->gender->value))
                ->toggleable(false),
            T\TextColumn::make("created_at")
                ->translateLabel()
                ->date("d M Y")
                ->toggleable(),
        ];
    }

    public static function userTableFilters(): array
    {
        return [
            // Filter for name
            Filter::make("name")
                ->form([
                    F\TextInput::make("name")
                        ->label("Search Name")
                        ->placeholder("Enter name to search"),
                ])
                ->query(
                    fn(Builder $query, array $data): Builder => $query->when(
                        $data["name"],
                        fn(Builder $query, $name) => $query->where(
                            "name",
                            "like",
                            "%{$name}%"
                        )
                    )
                ),

            // Filter for email
            Filter::make("email")
                ->form([
                    F\TextInput::make("email")
                        ->label("Search Email")
                        ->placeholder("Enter email to search"),
                ])
                ->query(
                    fn(Builder $query, array $data): Builder => $query->when(
                        $data["email"],
                        fn(Builder $query, $email) => $query->where(
                            "email",
                            "like",
                            "%{$email}%"
                        )
                    )
                ),

            // Filter for phoneNumber
            Filter::make("phoneNumber")
                ->form([
                    F\TextInput::make("phoneNumber")
                        ->label("Search Phone")
                        ->placeholder("Enter phone to search"),
                ])
                ->query(
                    fn(Builder $query, array $data): Builder => $query->when(
                        $data["phoneNumber"],
                        fn(Builder $query, $phone) => $query->where(
                            "phoneNumber",
                            "like",
                            "%{$phone}%"
                        )
                    )
                ),

            // Filter for email verification status with options array
            SelectFilter::make("email_verified_at")
                ->label("Email Verified")
                ->options([
                    "verified" => __("verified"),
                    "unverified" => __("unverified"),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data["value"] === "verified",
                            fn($query) => $query->whereNotNull(
                                "email_verified_at"
                            )
                        )
                        ->when(
                            $data["value"] === "unverified",
                            fn($query) => $query->whereNull("email_verified_at")
                        );
                }),

            // Filter for gender
            SelectFilter::make("gender")
                ->options([
                    "male" => __("male"),
                    "female" => __("female"),
                ])
                ->translateLabel(),

            // Filter for soft deleted records with options array
            SelectFilter::make("trashed")
                ->label("Deleted Status")
                ->options([
                    "deleted" => __("deleted"),
                    "not-deleted" => __("not-deleted"),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data["value"] === "deleted",
                            fn($query) => $query->onlyTrashed()
                        )
                        ->when(
                            $data["value"] === "not-deleted",
                            fn($query) => $query->withoutTrashed()
                        );
                }),

            // Date range filter for creation date
            Filter::make("created_at")
                ->form([
                    F\DatePicker::make("created_from")->translateLabel(),
                    F\DatePicker::make("created_until")->translateLabel(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data["created_from"],
                            fn(Builder $query, $date) => $query->whereDate(
                                "created_at",
                                ">=",
                                $date
                            )
                        )
                        ->when(
                            $data["created_until"],
                            fn(Builder $query, $date) => $query->whereDate(
                                "created_at",
                                "<=",
                                $date
                            )
                        );
                })
                ->columns(2),

            // Filter for active state with options array
            activeToggler(),
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

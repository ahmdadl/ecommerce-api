<?php

namespace Modules\Cities\Filament\Resources;

use Modules\Cities\Filament\Resources\CityResource\Pages;
use Modules\Cities\Filament\Resources\CityResource\RelationManagers;
use Modules\Cities\Models\City;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Components as I;
use Filament\Tables\Columns as C;
use Filament\Tables\Filters as F;
use Filament\Tables\Actions as A;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Enums\FiltersLayout;

class CityResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            I\Select::make("government_id")
                ->relationship("government", "title")
                ->required()
                ->translateLabel()
                ->columnSpanFull(),

            ...multiLangInput(
                I\TextInput::make("title")
                    ->translateLabel()
                    ->required()
                    ->maxLength(150)
            ),

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
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("government.title")->searchable(),

                C\IconColumn::make("is_active")->boolean(),

                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("deleted_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    F\SelectFilter::make("government_id")
                        ->relationship("government", "title")
                        ->searchable()
                        ->translateLabel(),

                    F\Filter::make("title")
                        ->form([
                            \Filament\Forms\Components\TextInput::make(
                                "title"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            return $query->when(
                                $data["title"],
                                fn($query) => $query
                                    ->where(
                                        "title->en",
                                        "like",
                                        "%{$data["title"]}%"
                                    )
                                    ->orWhere(
                                        "title->ar",
                                        "like",
                                        "%{$data["title"]}%"
                                    )
                            );
                        }),

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

                    F\TrashedFilter::make()->translateLabel(),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                A\EditAction::make()->iconButton(),
                A\DeleteAction::make()->iconButton(),
                A\RestoreAction::make(),
                A\ReplicateAction::make(),
            ])
            ->bulkActions([
                A\BulkActionGroup::make([A\DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCities::route("/"),
            "create" => Pages\CreateCity::route("/create"),
            "edit" => Pages\EditCity::route("/{record}/edit"),
        ];
    }
}

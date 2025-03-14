<?php

namespace Modules\Governments\Filament\Resources;

use Modules\Governments\Filament\Resources\GovernmentResource\Pages;
use Modules\Governments\Filament\Resources\GovernmentResource\RelationManagers;
use Modules\Governments\Models\Government;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Tables\Enums\FiltersLayout;

class GovernmentResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Government::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    protected static ?string $navigationGroup = "localization";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            ...multiLangInput(
                Forms\Components\TextInput::make("title")
                    ->translateLabel()
                    ->required()
            ),
            Forms\Components\TextInput::make("shippingFees")
                ->translateLabel()
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make("is_active")
                ->translateLabel()
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("title")
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make("shippingFees")
                    ->numeric()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make("is_active")->boolean(),

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("deleted_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    Tables\Filters\Filter::make("search")
                        ->form([
                            Forms\Components\TextInput::make("search")
                                ->label("Search")
                                ->placeholder("Search by title"),
                        ])
                        ->query(function ($query, array $data) {
                            if ($data["search"]) {
                                $query->where(function ($query) use ($data) {
                                    $search = $data["search"];
                                    $query
                                        ->where(
                                            "title->en",
                                            "like",
                                            "%{$search}%"
                                        )
                                        ->orWhere(
                                            "title->ar",
                                            "like",
                                            "%{$search}%"
                                        );
                                });
                            }
                        })
                        ->indicateUsing(function (array $data): ?string {
                            return $data["search"]
                                ? "Searching for: {$data["search"]}"
                                : null;
                        }),

                    Tables\Filters\Filter::make("created_at")
                        ->form([
                            Forms\Components\DatePicker::make(
                                "created_from"
                            )->translateLabel(),
                            Forms\Components\DatePicker::make(
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
                    Tables\Filters\TrashedFilter::make()->translateLabel(),
                    activeToggler(),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ReplicateAction::make(),
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
            "index" => Pages\ListGovernments::route("/"),
            "create" => Pages\CreateGovernment::route("/create"),
            "edit" => Pages\EditGovernment::route("/{record}/edit"),
        ];
    }
}

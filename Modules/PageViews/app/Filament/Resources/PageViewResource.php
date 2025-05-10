<?php

namespace Modules\PageViews\Filament\Resources;

use Modules\PageViews\Filament\Resources\PageViewResource\Pages;
use Modules\PageViews\Filament\Resources\PageViewResource\RelationManagers;
use Modules\PageViews\Models\PageView;
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

class PageViewResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PageView::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getNavigationGroup(): ?string
    {
        return __("Content Management");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["view"];
    }

    public static function canCreate(): bool
    {
        return false;
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
                C\TextColumn::make("viewable_type")->searchable()->toggleable(),
                C\TextColumn::make("viewable_id")->searchable()->toggleable(),
                C\TextColumn::make("viewerable_type")
                    ->searchable()
                    ->toggleable(),
                C\TextColumn::make("viewerable_id")->searchable()->toggleable(),
                C\TextColumn::make("ip_address")->searchable()->toggleable(),
                C\TextColumn::make("page")->searchable()->toggleable(),
                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    //

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
            ->actions([]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListPageViews::route("/"),
        ];
    }
}

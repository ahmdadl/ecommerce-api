<?php

namespace Modules\Faqs\Filament\Resources;

use Modules\Faqs\Filament\Resources\FaqCategoryResource\Pages;
use Modules\Faqs\Filament\Resources\FaqCategoryResource\RelationManagers;
use Modules\Faqs\Models\FaqCategory;
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

class FaqCategoryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = FaqCategory::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    protected static ?string $navigationGroup = "Faq";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "reorder"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            ...multiLangInput(
                I\Textarea::make("title")->required()->columnSpanFull()
            ),

            I\Toggle::make("is_active")->translateLabel()->default(true),
            sortOrderInput(static::$model),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                C\TextColumn::make("id")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                C\TextColumn::make("title")
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                C\ToggleColumn::make("is_active")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(true),

                C\TextColumn::make("sort_order")->numeric()->sortable(),

                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
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
                A\DeleteAction::make()->iconButton(),
                A\RestoreAction::make(),
            ])
            ->bulkActions([
                A\BulkActionGroup::make([A\DeleteBulkAction::make()]),
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
            "index" => Pages\ListFaqCategories::route("/"),
            "create" => Pages\CreateFaqCategory::route("/create"),
            "edit" => Pages\EditFaqCategory::route("/{record}/edit"),
        ];
    }
}

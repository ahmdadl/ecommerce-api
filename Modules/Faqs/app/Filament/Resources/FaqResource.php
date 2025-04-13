<?php

namespace Modules\Faqs\Filament\Resources;

use Modules\Faqs\Filament\Resources\FaqResource\Pages;
use Modules\Faqs\Filament\Resources\FaqResource\RelationManagers;
use Modules\Faqs\Models\Faq;
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

class FaqResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "reorder"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            I\Select::make("faq_category_id")
                ->label("Category")
                ->relationship("category", "title")
                ->searchable()
                ->preload()
                ->required(),

            I\Toggle::make("is_active")->translateLabel()->default(true),

            ...multiLangInput(
                I\Textarea::make("question")->required()->maxLength(255)
            ),
            ...multiLangInput(
                I\Textarea::make("answer")->required()->maxLength(500)
            ),

            sortOrderInput(static::$model),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                C\TextColumn::make("category.title")
                    ->label(__("Category"))
                    ->searchable()
                    ->sortable(),
                C\TextColumn::make("question")
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                C\TextColumn::make("answer")
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\ToggleColumn::make("is_active")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(true),

                C\TextColumn::make("sort_order")
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    F\SelectFilter::make("faq_category_id")
                        ->relationship("category", "title")
                        ->searchable()
                        ->translateLabel(),

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
            "index" => Pages\ListFaqs::route("/"),
            "create" => Pages\CreateFaq::route("/create"),
            "edit" => Pages\EditFaq::route("/{record}/edit"),
        ];
    }
}

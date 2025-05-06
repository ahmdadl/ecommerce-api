<?php

namespace Modules\Terms\Filament\Resources;

use Modules\Terms\Filament\Resources\TermResource\Pages;
use Modules\Terms\Filament\Resources\TermResource\RelationManagers;
use Modules\Terms\Models\Term;
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

class TermResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Term::class;

    protected static ?string $navigationIcon = "heroicon-o-document";

    public static function getNavigationGroup(): ?string
    {
        return __("Privacy");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["create", "update", "delete", "replicate", "reorder"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            ...multiLangInput(
                I\Textarea::make("title")->required()->translateLabel()
            ),
            ...multiLangInput(
                I\RichEditor::make("content")->required()->translateLabel()
            ),
            I\Toggle::make("is_active")->default(true)->translateLabel(),
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
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\TextColumn::make("title")->searchable()->translateLabel(),
                C\TextColumn::make("content")
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true),
                C\IconColumn::make("is_active")->boolean(),
                C\TextColumn::make("sort_order")->numeric()->sortable(),
                C\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    F\Filter::make("search")
                        ->form([
                            I\TextInput::make("search")
                                ->label("Search")
                                ->placeholder("Search by title, content"),
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
                                        )
                                        ->orWhere(
                                            "content->en",
                                            "like",
                                            "%{$search}%"
                                        )
                                        ->orWhere(
                                            "content->ar",
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
                A\ReplicateAction::make(),
            ])
            ->bulkActions([
                A\BulkActionGroup::make([A\DeleteBulkAction::make()]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->orderBy("sort_order");
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTerms::route("/"),
            "create" => Pages\CreateTerm::route("/create"),
            "edit" => Pages\EditTerm::route("/{record}/edit"),
        ];
    }
}

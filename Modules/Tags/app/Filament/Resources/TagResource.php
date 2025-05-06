<?php

namespace Modules\Tags\Filament\Resources;

use Modules\Tags\Filament\Resources\TagResource\Pages;
use Modules\Tags\Filament\Resources\TagResource\RelationManagers;
use Modules\Tags\Models\Tag;
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

class TagResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Tag::class;

    protected static ?string $navigationIcon = "heroicon-o-bookmark";

    protected static ?string $navigationGroup = "Catalog";

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            I\Tabs::make("categoryDetails")
                ->translateLabel()
                ->tabs([
                    I\Tabs\Tab::make("content")
                        ->icon("heroicon-o-globe-alt")
                        ->translateLabel()
                        ->schema([
                            ...multiLangInput(
                                I\TextInput::make("title")
                                    ->translateLabel()
                                    ->required()
                            ),
                            ...multiLangInput(
                                I\Textarea::make("description")
                                    ->translateLabel()
                                    ->rows(4)
                            ),
                        ])
                        ->columns(2),
                    I\Tabs\Tab::make("settings")
                        ->icon("heroicon-o-cog")
                        ->translateLabel()
                        ->schema([
                            I\Toggle::make("is_active")
                                ->translateLabel()
                                ->default(true),
                        ])
                        ->columns(2),
                    metaTabInputs(),
                ])
                ->columnSpanFull(),
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

                C\TextColumn::make("title")
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),

                C\TextColumn::make("slug")
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),

                C\TextColumn::make("products_count")
                    ->translateLabel()
                    ->sortable()
                    ->numeric()
                    ->toggleable(),

                C\ToggleColumn::make("is_active")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                C\TextColumn::make("created_at")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount("products");
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTags::route("/"),
            "create" => Pages\CreateTag::route("/create"),
            "edit" => Pages\EditTag::route("/{record}/edit"),
        ];
    }
}

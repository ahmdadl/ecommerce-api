<?php

namespace Modules\PageMetas\Filament\Resources;

use Modules\PageMetas\Filament\Resources\PageMetaResource\Pages;
use Modules\PageMetas\Filament\Resources\PageMetaResource\RelationManagers;
use Modules\PageMetas\Models\PageMeta;
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
use Modules\Core\Utils\FilamentUtils;

class PageMetaResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PageMeta::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function getPermissionPrefixes(): array
    {
        return ["create", "update", "delete", "replicate"];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            I\TextInput::make("page_url")
                ->required()
                ->maxLength(255)
                ->columnSpanFull(),
            ...multiLangInput(
                I\TextInput::make("title")->translateLabel()->required()
            ),
            ...multiLangInput(
                I\Textarea::make("description")->translateLabel()
            ),
            I\TagsInput::make("keywords")
                ->columnSpanFull()
                ->translateLabel()
                ->placeholder(__("keywords")),

            I\FileUpload::make("image")
                ->translateLabel()
                ->image()
                ->maxSize(1 * 512)
                ->disk("public")
                ->helperText("Maximum file size: 0.5MB.")
                ->storeFiles(false)
                ->dehydrateStateUsing(
                    fn($state) => FilamentUtils::storeSingleFile($state)
                ),
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
                C\ImageColumn::make("image"),
                C\TextColumn::make("page_url")->searchable(),
                C\TextColumn::make("title")
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                C\TextColumn::make("created_at")
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
            ->actions([
                A\EditAction::make()->iconButton(),
                A\DeleteAction::make()->iconButton(),
                A\ReplicateAction::make(),
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
            "index" => Pages\ListPageMetas::route("/"),
            "create" => Pages\CreatePageMeta::route("/create"),
            "edit" => Pages\EditPageMeta::route("/{record}/edit"),
        ];
    }
}

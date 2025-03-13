<?php

namespace Modules\Banners\Filament\Resources;

use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Modules\Banners\Filament\Resources\BannerResource\Pages;
use Modules\Banners\Filament\Resources\BannerResource\RelationManagers;
use Modules\Banners\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Modules\Banners\Enums\BannerActionType;
use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Core\Utils\FilamentUtils;
use Modules\Products\Models\Product;
use Modules\Uploads\Models\Upload;

class BannerResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            ...multiLangInput(
                Forms\Components\TextInput::make("title")
                    ->translateLabel()
                    ->required()
                    ->maxLength(100)
            ),
            ...multiLangInput(
                Forms\Components\TextInput::make("subtitle")
                    ->translateLabel()
                    ->maxLength(255)
            ),

            Forms\Components\ToggleButtons::make("action")
                ->options(enumOptions(BannerActionType::class))
                ->default(BannerActionType::MEDIA->value)
                ->reactive()
                ->required()
                ->inline()
                ->grouped(),

            Forms\Components\MorphToSelect::make("actionable")
                ->translateLabel()
                ->types([
                    Forms\Components\MorphToSelect\Type::make(
                        Product::class
                    )->titleAttribute("title"),
                    Forms\Components\MorphToSelect\Type::make(
                        Category::class
                    )->titleAttribute("title"),
                    Forms\Components\MorphToSelect\Type::make(
                        Brand::class
                    )->titleAttribute("title"),
                ])
                ->reactive()
                ->searchable()
                ->required()
                ->hidden(fn(callable $get) => $get("action") === "media"),
            Forms\Components\TextInput::make("sort_order")
                ->numeric()
                ->default(1),
            Forms\Components\Toggle::make("is_active")->default(true),
            Forms\Components\FileUpload::make("media")
                ->translateLabel()
                ->acceptedFileTypes([
                    "image/jpeg",
                    "image/png",
                    "image/jpg",
                    "image/webp",
                    "video/mp4",
                ])
                ->maxSize(1.5 * 1024)
                ->disk("public")
                ->helperText("Maximum file size: 1.5MB.")
                ->storeFiles(false)
                ->dehydrateStateUsing(
                    fn($state) => FilamentUtils::storeSingleFile($state)
                )
                ->columnSpanFull()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label("ID")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\ImageColumn::make("media")->circular(),

                Tables\Columns\TextColumn::make("title")
                    ->translateLabel()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->description(
                        fn(Banner $record): string => str($record->subtitle)
                            ->limit(50)
                            ->toString()
                    ),

                Tables\Columns\TextColumn::make("action")
                    ->translateLabel()
                    ->badge()
                    ->formatStateUsing(
                        fn(BannerActionType $state): string => __($state->value)
                    )
                    ->color(
                        fn(BannerActionType $state): string => $state->color()
                    )
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("actionable.title")
                    ->description(
                        fn(Banner $record): string => $record->actionable
                            ?->id ?? ""
                    )
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("sort_order")
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make("is_active")->boolean(),

                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("updated_at")
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
                                ->placeholder("Search by title, subtitle"),
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
                                            "subtitle->en",
                                            "like",
                                            "%{$search}%"
                                        )
                                        ->orWhere(
                                            "subtitle->ar",
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

                    activeToggler(),
                ],
                FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(2)
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
            "index" => Pages\ListBanners::route("/"),
            "create" => Pages\CreateBanner::route("/create"),
            "edit" => Pages\EditBanner::route("/{record}/edit"),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with("actionable");
    }

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }
}

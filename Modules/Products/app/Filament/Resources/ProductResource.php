<?php

namespace Modules\Products\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Modules\Core\Utils\FilamentUtils;
use Modules\Products\Filament\Resources\ProductResource\Pages;
use Modules\Products\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = "heroicon-o-cube";

    protected static ?string $navigationGroup = "Catalog";

    public static function getNavigationBadge(): ?string
    {
        return (string) static::$model::count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make("productDetails")
                ->translateLabel()
                ->tabs([
                    Forms\Components\Tabs\Tab::make("content")
                        ->icon("heroicon-o-globe-alt")
                        ->translateLabel()
                        ->schema([
                            ...multiLangInput(
                                Forms\Components\TextInput::make("title")
                                    ->translateLabel()
                                    ->required()
                            ),
                            ...multiLangInput(
                                Forms\Components\RichEditor::make(
                                    "description"
                                )->translateLabel()
                            ),
                        ])
                        ->columns(2),

                    Forms\Components\Tabs\Tab::make("images")
                        ->icon("heroicon-o-photo")
                        ->translateLabel()
                        ->schema([
                            Forms\Components\FileUpload::make("images")
                                ->translateLabel()
                                ->image()
                                ->multiple()
                                ->reorderable()
                                ->maxSize(1 * 1024)
                                ->disk("public")
                                ->helperText("Maximum file size: 1MB.")
                                ->storeFiles(false)
                                ->dehydrateStateUsing(
                                    fn(
                                        $state
                                    ) => FilamentUtils::storeMultipleFile(
                                        $state
                                    )
                                ),
                        ]),
                    Forms\Components\Tabs\Tab::make("relations")
                        ->icon("heroicon-o-link")
                        ->translateLabel()
                        ->schema([
                            Forms\Components\Select::make("category_id")
                                ->label("Category")
                                ->relationship("category", "title")
                                ->searchable()
                                ->preload()
                                ->required(),

                            Forms\Components\Select::make("brand_id")
                                ->label("Brand")
                                ->relationship("brand", "title")
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                    Forms\Components\Tabs\Tab::make("price")
                        ->icon("heroicon-o-currency-dollar")
                        ->translateLabel()
                        ->schema([
                            Forms\Components\TextInput::make("price")
                                ->label("Price")
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->prefix('$')
                                ->step(0.01),

                            Forms\Components\TextInput::make("salePrice")
                                ->label("Sale Price")
                                ->numeric()
                                ->minValue(0)
                                ->prefix('$')
                                ->step(0.01),

                            Forms\Components\TextInput::make("stock")
                                ->label("Stock")
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->default(0),
                        ])
                        ->columns(2),

                    Forms\Components\Tabs\Tab::make("settings")
                        ->icon("heroicon-o-cog")
                        ->translateLabel()
                        ->schema([
                            Forms\Components\TextInput::make("sku")
                                ->label("SKU")
                                ->maxLength(50)
                                ->unique(
                                    Product::class,
                                    "sku",
                                    ignoreRecord: true
                                ),

                            Forms\Components\Toggle::make("is_main")
                                ->label("Is Main Product")
                                ->default(false),

                            Forms\Components\Toggle::make("is_active")
                                ->label("Is Active")
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
                ImageColumn::make("image")
                    ->translateLabel()
                    ->getStateUsing(
                        fn($record): ?string => !empty($record->images)
                            ? uploads_url(
                                $record->images[
                                    array_key_first($record->images)
                                ]
                            )
                            : null
                    )
                    ->label("image")
                    ->circular(),

                TextColumn::make("title")
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make("slug")
                    ->translateLabel()
                    ->searchable()
                    ->sortable()
                    ->toggleable(true),

                TextColumn::make("category.title")
                    ->label(__("Category"))
                    ->searchable()
                    ->sortable(),

                TextColumn::make("brand.title")
                    ->label(__("Brand"))
                    ->searchable()
                    ->sortable(),

                TextColumn::make("price")
                    ->translateLabel()
                    ->money("egp")
                    ->sortable(),

                TextColumn::make("salePrice")
                    ->translateLabel()
                    ->money("egp")
                    ->sortable(),

                TextColumn::make("discountedPrice")
                    ->translateLabel()
                    ->money("egp")
                    ->sortable()
                    ->toggleable(true),

                TextColumn::make("stock")
                    ->translateLabel()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(true),

                TextColumn::make("sku")
                    ->translateLabel()
                    ->searchable()
                    ->toggleable(true),

                ToggleColumn::make("is_main")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(true),

                ToggleColumn::make("is_active")
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(true),

                TextColumn::make("created_at")
                    ->translateLabel()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(
                [
                    SelectFilter::make("category_id")
                        ->relationship("category", "title")
                        ->searchable()
                        ->translateLabel(),

                    SelectFilter::make("brand_id")
                        ->relationship("brand", "title")
                        ->searchable()
                        ->translateLabel(),

                    Filter::make("title")
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

                    Tables\Filters\TernaryFilter::make(
                        "is_main"
                    )->translateLabel(),

                    Filter::make("price")
                        ->form([
                            \Filament\Forms\Components\TextInput::make(
                                "price_min"
                            )
                                ->numeric()
                                ->label(__("Min Price")),
                            \Filament\Forms\Components\TextInput::make(
                                "price_max"
                            )
                                ->numeric()
                                ->label(__("Max Price")),
                        ])
                        ->query(function ($query, array $data) {
                            return $query
                                ->when(
                                    $data["price_min"],
                                    fn($query) => $query->where(
                                        "price",
                                        ">=",
                                        $data["price_min"]
                                    )
                                )
                                ->when(
                                    $data["price_max"],
                                    fn($query) => $query->where(
                                        "price",
                                        "<=",
                                        $data["price_max"]
                                    )
                                );
                        }),

                    Filter::make("stock")
                        ->form([
                            \Filament\Forms\Components\TextInput::make(
                                "stock_min"
                            )
                                ->numeric()
                                ->label(__("Min Stock")),
                            \Filament\Forms\Components\TextInput::make(
                                "stock_max"
                            )
                                ->numeric()
                                ->label(__("Max Stock")),
                        ])
                        ->query(function ($query, array $data) {
                            return $query
                                ->when(
                                    $data["stock_min"],
                                    fn($query) => $query->where(
                                        "stock",
                                        ">=",
                                        $data["stock_min"]
                                    )
                                )
                                ->when(
                                    $data["stock_max"],
                                    fn($query) => $query->where(
                                        "stock",
                                        "<=",
                                        $data["stock_max"]
                                    )
                                );
                        }),

                    Filter::make("sku")
                        ->form([
                            \Filament\Forms\Components\TextInput::make(
                                "sku"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            return $query->when(
                                $data["sku"],
                                fn($query) => $query->where(
                                    "sku",
                                    "like",
                                    "%{$data["sku"]}%"
                                )
                            );
                        }),

                    activeToggler(),

                    Filter::make("created_at")
                        ->form([
                            \Filament\Forms\Components\DatePicker::make(
                                "created_from"
                            )->translateLabel(),
                            \Filament\Forms\Components\DatePicker::make(
                                "created_until"
                            )->translateLabel(),
                        ])
                        ->query(function ($query, array $data) {
                            return $query
                                ->when(
                                    $data["created_from"],
                                    fn($query) => $query->whereDate(
                                        "created_at",
                                        ">=",
                                        $data["created_from"]
                                    )
                                )
                                ->when(
                                    $data["created_until"],
                                    fn($query) => $query->whereDate(
                                        "created_at",
                                        "<=",
                                        $data["created_until"]
                                    )
                                );
                        }),

                    Tables\Filters\TrashedFilter::make()->translateLabel(),
                ],
                layout: FiltersLayout::AboveContentCollapsible
            )
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
                Tables\Actions\RestoreAction::make()->iconButton(),
                Tables\Actions\ReplicateAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListProducts::route("/"),
            "create" => Pages\CreateProduct::route("/create"),
            "edit" => Pages\EditProduct::route("/{record}/edit"),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }
}

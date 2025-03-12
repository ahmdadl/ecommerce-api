<?php

namespace Modules\Coupons\Filament\Resources;

use Filament\Tables\Filters\SelectFilter;
use Modules\Coupons\Filament\Resources\CouponResource\Pages;
use Modules\Coupons\Filament\Resources\CouponResource\RelationManagers;
use Modules\Coupons\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Enums\CouponDiscountType;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("code")
                    ->translateLabel()
                    ->required()
                    ->maxLength(50)
                    ->unique(Coupon::class, "code", ignoreRecord: true)
                    ->placeholder("e.g., SAVE20"),

                Forms\Components\TextInput::make("name")
                    ->translateLabel()
                    ->maxLength(255)
                    ->placeholder("e.g., 20% Off Summer Sale"),

                Forms\Components\DatePicker::make("starts_at")
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->displayFormat("Y-m-d"),

                Forms\Components\DatePicker::make("ends_at")
                    ->translateLabel()
                    ->required()
                    ->native(false)
                    ->displayFormat("Y-m-d")
                    ->after("starts_at"),

                Forms\Components\Select::make("discount_type")
                    ->label("Discount Type")
                    ->options(CouponDiscountType::class)
                    ->enum(CouponDiscountType::class)
                    ->default(CouponDiscountType::PERCENTAGE)
                    ->required(),

                Forms\Components\TextInput::make("value")
                    ->translateLabel()
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->suffix(
                        fn(Forms\Get $get) => $get("discount_type") ===
                        CouponDiscountType::PERCENTAGE->value
                            ? "%"
                            : "EGP"
                    ),

                Forms\Components\TextInput::make("max_discount")
                    ->translateLabel()
                    ->numeric()
                    ->minValue(0)
                    ->nullable()
                    ->suffix("EGP")
                    ->helperText(
                        __("Leave blank for no maximum discount limit.")
                    ),

                Forms\Components\Toggle::make("is_active")
                    ->label("Is Active")
                    ->default(true),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id")
                    ->label("ID")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("code")->searchable(),
                Tables\Columns\TextColumn::make("name")
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("starts_at")
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make("ends_at")->date()->sortable(),
                Tables\Columns\TextColumn::make("discount_type"),
                Tables\Columns\TextColumn::make("value")->numeric()->sortable(),
                Tables\Columns\TextColumn::make("max_discount")
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make("used_count")
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make("is_active")->boolean(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
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
                    Filter::make("name")
                        ->form([
                            Forms\Components\TextInput::make(
                                "name"
                            )->translateLabel(),
                        ])
                        ->query(
                            fn(
                                Builder $query,
                                array $data
                            ): Builder => $query->when(
                                $data["name"],
                                fn(Builder $query, $name) => $query->where(
                                    "name",
                                    "like",
                                    "%{$name}%"
                                )
                            )
                        )
                        ->indicateUsing(
                            fn(array $data): ?string => $data["name"]
                                ? "Name: {$data["name"]}"
                                : null
                        ),

                    Filter::make("code")
                        ->form([
                            Forms\Components\TextInput::make(
                                "code"
                            )->translateLabel(),
                        ])
                        ->query(
                            fn(
                                Builder $query,
                                array $data
                            ): Builder => $query->when(
                                $data["code"],
                                fn(Builder $query, $code) => $query->where(
                                    "code",
                                    "like",
                                    "%{$code}%"
                                )
                            )
                        )
                        ->indicateUsing(
                            fn(array $data): ?string => $data["code"]
                                ? "Code: {$data["code"]}"
                                : null
                        ),

                    SelectFilter::make("discount_type")
                        ->translateLabel()
                        ->options(CouponDiscountType::class),

                    Filter::make("active_date")
                        ->label(__("active_dates"))
                        ->toggle()
                        ->query(
                            fn(Builder $query) => $query
                                ->where("starts_at", "<=", now())
                                ->where("ends_at", ">=", now())
                        ),
                    Filter::make("used_count")
                        ->label(__("is_used"))
                        ->toggle()
                        ->query(
                            fn(Builder $query) => $query->where(
                                "used_count",
                                ">",
                                0
                            )
                        ),

                    Filter::make("is_validated")
                        ->label(__("validated"))
                        ->toggle()
                        ->query(function (Builder $query) {
                            $validator = new ValidateCouponAction();

                            $totalPrice = PHP_INT_MAX;

                            // Get all coupon IDs first to avoid loading full records unnecessarily
                            $validIds = $query
                                ->pluck("id")
                                ->filter(function ($id) use (
                                    $validator,
                                    $totalPrice
                                ) {
                                    $coupon = Coupon::find($id);
                                    try {
                                        $validator->handle(
                                            $coupon,
                                            $totalPrice
                                        );
                                        return true;
                                    } catch (\Throwable $e) {
                                        return false;
                                    }
                                })
                                ->all();

                            return $query->whereIn("id", $validIds);
                        }),

                    activeToggler(),

                    TrashedFilter::make("trashed")->translateLabel(),
                ],
                FiltersLayout::AboveContentCollapsible
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

    public static function getRelations(): array
    {
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCoupons::route("/"),
            "create" => Pages\CreateCoupon::route("/create"),
            "edit" => Pages\EditCoupon::route("/{record}/edit"),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return ["view", "create", "update", "delete", "restore", "replicate"];
    }
}

<?php

namespace Modules\Settings\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Utils\FilamentUtils;
use Modules\Settings\Models\Setting;
use Modules\Settings\Filament\Resources\SettingResource\Pages;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = "heroicon-o-cog";

    protected static ?string $navigationLabel = "Settings";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make("Settings")
                    ->translateLabel()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make("general")
                            ->translateLabel()
                            ->schema([
                                ...multiLangInput(
                                    Forms\Components\TextInput::make(
                                        "data.general.name"
                                    )
                                        ->label(__("SiteName"))
                                        ->required()
                                        ->maxLength(255)
                                ),
                                ...multiLangInput(
                                    Forms\Components\Textarea::make(
                                        "data.general.description"
                                    )
                                        ->label(__("SiteDescription"))
                                        ->maxLength(500)
                                ),
                                Forms\Components\Toggle::make(
                                    "data.general.maintenance_mode"
                                )
                                    ->label(__("MaintenanceMode"))
                                    ->default(false),
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make("contact")
                            ->translateLabel()
                            ->schema([
                                Forms\Components\TextInput::make(
                                    "data.contact.email"
                                )
                                    ->label(__("email"))
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TagsInput::make(
                                    "data.contact.phoneNumbers"
                                )
                                    ->label(__("phoneNumbers"))
                                    ->placeholder(__("phoneNumbers")),
                                Forms\Components\TextInput::make(
                                    "data.contact.address"
                                )
                                    ->label(__("address"))
                                    ->maxLength(255),
                                Forms\Components\TextInput::make(
                                    "data.contact.googleMapUrl"
                                )
                                    ->label(__("googleMapUrl"))
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make("social")
                            ->translateLabel()
                            ->schema([
                                Forms\Components\TextInput::make(
                                    "data.social.facebook"
                                )
                                    ->label(__("facebook"))
                                    ->url()
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make("top_header")
                            ->translateLabel()
                            ->schema([
                                ...multiLangInput(
                                    Forms\Components\Textarea::make(
                                        "data.top_header.body"
                                    )
                                        ->translateLabel()
                                        ->maxLength(500)
                                ),
                                // Forms\Components\FileUpload::make(
                                //     "data.top_header.image"
                                // )
                                //     ->translateLabel()
                                //     ->image()
                                //     ->maxSize(1 * 512)
                                //     ->disk("public")
                                //     ->helperText("Maximum file size: .5MB.")
                                //     ->storeFiles(false)
                                //     ->dehydrateStateUsing(
                                //         fn($state) => $state &&
                                //             FilamentUtils::storeSingleFile(
                                //                 $state
                                //             )
                                //     ),

                                Forms\Components\Toggle::make(
                                    "data.top_header.is_active"
                                )
                                    ->translateLabel()
                                    ->default(true),

                                Forms\Components\DateTimePicker::make(
                                    "data.top_header.end_time"
                                )
                                    ->translateLabel()
                                    ->minDate(now()),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(), // Ensure tabs span the full width
            ])
            ->columns(1); // Single-column layout within each tab
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\EditSetting::route("/"),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where("id", 1); // Always use the first record
    }
}

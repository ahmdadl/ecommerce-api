<?php

if (!function_exists("api")) {
    /**
     * api response
     *
     * @return \Modules\Core\Utils\ApiResponse
     */
    function api()
    {
        return app(\Modules\Core\Utils\ApiResponse::class);
    }
}

if (!function_exists("user")) {
    /**
     * get current user
     */
    function user(?string $guard = null): ?\Modules\Users\Models\User
    {
        return auth()->guard($guard)->user();
    }
}

if (!function_exists("settings")) {
    function settings(string $group = null)
    {
        $settings = \Modules\Settings\Utils\SettingUtils::getCachedSettings();

        if ($group === null) {
            return $settings;
        }

        return $settings[$group] ?? null;
    }
}

if (!function_exists("multiLangInput")) {
    function multiLangInput(
        Filament\Forms\Components\TextInput|Filament\Forms\Components\Textarea $input
    ) {
        $clone = clone $input;
        $name = $input->getName();
        $label = $input->getLabel();

        $enLabel = __("english_label", compact("label"));
        $arLabel = __("arabic_label", compact("label"));

        return [
            $input
                ->make($name . ".en")
                ->label($enLabel)
                ->required($input->isRequired()),
            $clone
                ->make($name . ".ar")
                ->label($arLabel)
                ->required($input->isRequired()),
        ];
    }
}

if (!function_exists("metaTabInputs")) {
    function metaTabInputs(): Filament\Forms\Components\Tabs\Tab
    {
        return Filament\Forms\Components\Tabs\Tab::make("meta")
            ->label("meta")
            ->translateLabel()
            ->icon("heroicon-m-queue-list")
            ->schema([
                ...multiLangInput(
                    Filament\Forms\Components\TextInput::make(
                        "meta_title"
                    )->translateLabel()
                ),
                ...multiLangInput(
                    Filament\Forms\Components\Textarea::make(
                        "meta_description"
                    )->translateLabel()
                ),
                Filament\Forms\Components\TagsInput::make("meta_keywords")
                    ->columnSpanFull()
                    ->translateLabel()
                    ->placeholder(__("meta_keywords")),
            ])
            ->columns(2);
    }
}

if (!function_exists("activeToggler")) {
    function activeToggler()
    {
        return Filament\Tables\Filters\Filter::make("is_active")
            ->form([
                Filament\Forms\Components\ToggleButtons::make("is_active")
                    ->label("Active")
                    ->translateLabel()
                    ->grouped()
                    ->options([
                        "active" => __("Active"),
                        "inactive" => __("Inactive"),
                        "all" => __("All"),
                    ])
                    ->icons([
                        "active" => "heroicon-o-shield-check",
                        "inactive" => "heroicon-o-shield-exclamation",
                        "all" => "heroicon-o-no-symbol",
                    ])
                    ->default("all"),
            ])
            ->query(function (
                Illuminate\Database\Eloquent\Builder $query,
                array $data
            ): Illuminate\Database\Eloquent\Builder {
                return $query->when(
                    $activeState = $data["is_active"],
                    fn($q) => $q
                        ->when(
                            $activeState === "active",
                            fn($q) => $q->where("is_active", true)
                        )
                        ->when(
                            $activeState === "inactive",
                            fn($q) => $q->where("is_active", false)
                        )
                );
            });
    }
}

// if (!function_exists("uploads_path")) {
//     function uploads_path(?string $path = null): string
//     {
//         $path = $path
//             ? DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR)
//             : "";

//         return storage_path(
//             "app" .
//                 DIRECTORY_SEPARATOR .
//                 "public" .
//                 DIRECTORY_SEPARATOR .
//                 Modules\Uploads\Models\Upload::UPLOAD_DIR .
//                 $path
//         );
//     }
// }

if (!function_exists("uploads_url")) {
    function uploads_url(?string $path = null): string
    {
        if (!$path) {
            return url("storage/uploads");
        }
        return url("storage/uploads/" . $path);
    }
}

if (!function_exists("sendMail")) {
    function sendMail(string $to, Illuminate\Mail\Mailable $mail): void
    {
        try {
            \Mail::to($to)->send($mail);
        } catch (\Throwable $th) {
            logger()->error($th->getMessage());
            throw $th;
        }
    }
}

if (!function_exists("enumOptions")) {
    function enumOptions($enum)
    {
        $options = [];
        foreach ($enum::cases() as $case) {
            $options[$case->value] = __($case->value);
        }
        return $options;
    }
}

if (!function_exists("testMail")) {
    function testMail(\Illuminate\Mail\Mailable $mailable)
    {
        return $mailable->toMail((object) [])->render();
    }
}

if (!function_exists("sortOrderInput")) {
    function sortOrderInput(string $model): Filament\Forms\Components\TextInput
    {
        return Filament\Forms\Components\TextInput::make("sort_order")
            ->translateLabel()
            ->numeric()
            ->default(fn() => $model::max("sort_order") + 1)
            ->suffixAction(
                Filament\Forms\Components\Actions\Action::make(
                    "latestSortOrder"
                )
                    ->icon("heroicon-m-wrench-screwdriver")
                    ->label(__("SetToLatest"))
                    ->action(function (Filament\Forms\Set $set, $state) use (
                        $model
                    ) {
                        $set("sort_order", $model::max("sort_order") + 1);
                    })
            );
    }
}

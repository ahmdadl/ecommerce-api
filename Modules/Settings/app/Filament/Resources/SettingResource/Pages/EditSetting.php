<?php

namespace Modules\Settings\Filament\Resources\SettingResource\Pages;

use Modules\Settings\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;
use Modules\Settings\Models\Setting;
use Modules\Settings\Utils\SettingUtils;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount($record = null): void
    {
        $this->record = $this->resolveRecord(1); // Always use ID 1

        if (!$this->record) {
            $this->record = SettingResource::getModel()::create([
                "id" => 1,
                "data" => [],
            ]);
        }

        $this->form->fill($this->record->toArray());
    }

    protected function afterSave(): void
    {
        // revalidate and recache
        SettingUtils::revalidateCachedSettings();
    }
}

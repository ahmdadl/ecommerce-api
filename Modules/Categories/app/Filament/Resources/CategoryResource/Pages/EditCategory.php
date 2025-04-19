<?php

namespace Modules\Categories\Filament\Resources\CategoryResource\Pages;

use Modules\Categories\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index"); // Redirect to resource index
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (empty($data["media"])) {
            return $data;
        }

        $data["media"] = basename($data["media"]);

        $data["media"] = \Modules\Uploads\Models\Upload::find(
            $data["media"]
        )?->path;

        return $data;
    }
}

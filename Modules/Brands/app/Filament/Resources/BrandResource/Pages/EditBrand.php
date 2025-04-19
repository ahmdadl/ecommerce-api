<?php

namespace Modules\Brands\Filament\Resources\BrandResource\Pages;

use Modules\Brands\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
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

<?php

namespace Modules\Banners\Filament\Resources\BannerResource\Pages;

use Modules\Banners\Filament\Resources\BannerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

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
        $data["media"] = basename($data["media"]);

        $data["media"] = \Modules\Uploads\Models\Upload::find(
            $data["media"]
        )?->path;

        return $data;
    }
}

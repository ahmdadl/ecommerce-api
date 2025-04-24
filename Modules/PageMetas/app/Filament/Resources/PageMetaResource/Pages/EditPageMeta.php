<?php

namespace Modules\PageMetas\Filament\Resources\PageMetaResource\Pages;

use Modules\PageMetas\Filament\Resources\PageMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPageMeta extends EditRecord
{
    protected static string $resource = PageMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {
        // $data["media"] = basename($data["media"]);

        // $data["media"] = \Modules\Uploads\Models\Upload::find(
            // $data["media"]
        // )?->path;

        // return $data;
    // }
}

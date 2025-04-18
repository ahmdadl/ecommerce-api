<?php

namespace Modules\Tags\Filament\Resources\TagResource\Pages;

use Modules\Tags\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTag extends EditRecord
{
    protected static string $resource = TagResource::class;

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

<?php

namespace Modules\Governments\Filament\Resources\GovernmentResource\Pages;

use Modules\Governments\Filament\Resources\GovernmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGovernment extends EditRecord
{
    protected static string $resource = GovernmentResource::class;

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

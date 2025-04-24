<?php

namespace Modules\Orders\Filament\Resources\OrderResource\Pages;

use Modules\Orders\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

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

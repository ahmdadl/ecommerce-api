<?php

namespace Modules\Faqs\Filament\Resources\FaqResource\Pages;

use Modules\Faqs\Filament\Resources\FaqResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaq extends EditRecord
{
    protected static string $resource = FaqResource::class;

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

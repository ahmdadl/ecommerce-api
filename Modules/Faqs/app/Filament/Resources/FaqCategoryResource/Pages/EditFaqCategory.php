<?php

namespace Modules\Faqs\Filament\Resources\FaqCategoryResource\Pages;

use Modules\Faqs\Filament\Resources\FaqCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaqCategory extends EditRecord
{
    protected static string $resource = FaqCategoryResource::class;

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

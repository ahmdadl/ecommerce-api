<?php

namespace Modules\Faqs\Filament\Resources\FaqCategoryResource\Pages;

use Modules\Faqs\Filament\Resources\FaqCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFaqCategory extends CreateRecord
{
    protected static string $resource = FaqCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}

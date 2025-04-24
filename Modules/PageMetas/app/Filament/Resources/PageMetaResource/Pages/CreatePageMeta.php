<?php

namespace Modules\PageMetas\Filament\Resources\PageMetaResource\Pages;

use Modules\PageMetas\Filament\Resources\PageMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePageMeta extends CreateRecord
{
    protected static string $resource = PageMetaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}

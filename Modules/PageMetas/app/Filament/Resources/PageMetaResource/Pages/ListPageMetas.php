<?php

namespace Modules\PageMetas\Filament\Resources\PageMetaResource\Pages;

use Modules\PageMetas\Filament\Resources\PageMetaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageMetas extends ListRecords
{
    protected static string $resource = PageMetaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

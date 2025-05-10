<?php

namespace Modules\PageViews\Filament\Resources\PageViewResource\Pages;

use Modules\PageViews\Filament\Resources\PageViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPageViews extends ListRecords
{
    protected static string $resource = PageViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

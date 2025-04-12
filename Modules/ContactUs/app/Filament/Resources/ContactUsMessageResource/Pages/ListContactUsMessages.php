<?php

namespace Modules\ContactUs\Filament\Resources\ContactUsMessageResource\Pages;

use Modules\ContactUs\Filament\Resources\ContactUsMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactUsMessages extends ListRecords
{
    protected static string $resource = ContactUsMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

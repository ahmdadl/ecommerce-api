<?php

namespace Modules\ContactUs\Filament\Resources\ContactUsMessageResource\Pages;

use Modules\ContactUs\Filament\Resources\ContactUsMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContactUsMessage extends CreateRecord
{
    protected static string $resource = ContactUsMessageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}

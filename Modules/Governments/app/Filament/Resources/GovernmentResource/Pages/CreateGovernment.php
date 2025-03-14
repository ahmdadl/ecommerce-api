<?php

namespace Modules\Governments\Filament\Resources\GovernmentResource\Pages;

use Modules\Governments\Filament\Resources\GovernmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGovernment extends CreateRecord
{
    protected static string $resource = GovernmentResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}

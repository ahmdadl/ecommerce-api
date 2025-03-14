<?php

namespace Modules\Governments\Filament\Resources\GovernmentResource\Pages;

use Modules\Governments\Filament\Resources\GovernmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGovernments extends ListRecords
{
    protected static string $resource = GovernmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

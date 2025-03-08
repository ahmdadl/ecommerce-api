<?php

namespace Modules\Categories\Filament\Resources\CategoryResource\Pages;

use Modules\Categories\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\Categories\Models\Category;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index"); // Redirect to resource index
    }
}

<?php

namespace Modules\Products\Filament\Resources\ProductResource\Pages;

use Modules\Products\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}

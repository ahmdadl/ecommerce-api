<?php

namespace Modules\Users\Filament\Resources\UserResource\Pages;

use Modules\Users\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;
}

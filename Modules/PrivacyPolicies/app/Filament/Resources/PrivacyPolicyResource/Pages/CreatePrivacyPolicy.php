<?php

namespace Modules\PrivacyPolicies\Filament\Resources\PrivacyPolicyResource\Pages;

use Modules\PrivacyPolicies\Filament\Resources\PrivacyPolicyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrivacyPolicy extends CreateRecord
{
    protected static string $resource = PrivacyPolicyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }
}

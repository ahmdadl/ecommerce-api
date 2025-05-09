<?php

namespace Modules\Wallets\Filament\Resources\WalletResource\Pages;

use Modules\Wallets\Filament\Resources\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Modules\Wallets\ValueObjects\WalletBalance;

class CreateWallet extends CreateRecord
{
    protected static string $resource = WalletResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data["balance"] = WalletBalance::default();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!isset($data["balance"])) {
            $data["balance"] = WalletBalance::default();
        }

        return $data;
    }
}

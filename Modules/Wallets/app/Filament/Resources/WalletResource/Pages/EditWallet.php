<?php

namespace Modules\Wallets\Filament\Resources\WalletResource\Pages;

use Modules\Wallets\Filament\Resources\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWallet extends EditRecord
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl("index");
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data["balance"] = $data["balance"]->toArray();

        return $data;
    }
}

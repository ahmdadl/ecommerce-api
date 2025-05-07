<?php

namespace Modules\Wallets\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Users\Models\Customer;
use Modules\Wallets\Database\Factories\WalletTransactionFactory;
use Modules\Wallets\Enums\WalletStatus;
use Modules\Wallets\Enums\WalletType;

#[UseFactory(WalletTransactionFactory::class)]
class WalletTransaction extends Model
{
    /** @use HasFactory<WalletTransactionFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "amount" => "float",
            "type" => WalletType::class,
            "status" => WalletStatus::class,
        ];
    }

    /**
     * wallet
     * @return BelongsTo<Wallet, $this>
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * created by user
     * @return BelongsTo<Customer, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Customer::class, "created_by");
    }
}

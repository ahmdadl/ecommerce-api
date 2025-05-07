<?php

namespace Modules\Wallets\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Scopes\HasActiveState;
use Modules\Users\Models\Customer;
use Modules\Wallets\Casts\WalletBalanceCast;
use Modules\Wallets\Database\Factories\WalletFactory;

#[UseFactory(WalletFactory::class)]
class Wallet extends Model
{
    /** @use HasFactory<WalletFactory> */
    use HasFactory, HasUlids, HasActiveState, SoftDeletes;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "balance" => WalletBalanceCast::class,
        ];
    }

    /**
     * user
     * @return BelongsTo<Customer, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * transactions
     * @return HasMany<WalletTransaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class);
    }
}

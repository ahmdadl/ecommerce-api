<?php

namespace Modules\Addresses\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Addresses\Database\Factories\AddressFactory;
use Modules\Users\Models\User;

#[UseFactory(AddressFactory::class)]
class Address extends Model
{
    /** @use HasFactory<AddressFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * owner of address
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace Modules\Wishlists\Actions;

use Modules\Core\Traits\HasActionHelpers;
use Modules\Wishlists\Services\WishlistService;

abstract class BaseWishlistAction
{
    public function __construct(public readonly WishlistService $service) {}

    /**
     * create new wishlist action
     */
    public static function new(): static
    {
        return new static(app(WishlistService::class));
    }
}

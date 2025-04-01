<?php

if (!function_exists("wishlistService")) {
    function wishlistService(): ?\Modules\Wishlists\Services\WishlistService
    {
        return app(\Modules\Wishlists\Services\WishlistService::class);
    }
}

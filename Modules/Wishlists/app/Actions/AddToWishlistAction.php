<?php

namespace Modules\Wishlists\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Products\Models\Product;

class AddToWishlistAction extends BaseWishlistAction
{
    public function handle(Product $product): void
    {
        if ($this->service->count() >= 10) {
            throw new ApiException(__("wishlists::t.wishlist_is_full"));
        }

        if ($this->service->hasProduct($product)) {
            throw new ApiException(
                __("wishlists::t.product_already_in_wishlist")
            );
        }

        $this->service->addItem($product);
    }
}

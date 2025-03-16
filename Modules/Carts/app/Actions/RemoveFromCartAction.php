<?php

namespace Modules\Carts\Actions;

use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Core\Exceptions\ApiException;
use Modules\Products\Models\Product;

class RemoveFromCartAction
{
    public function __construct(public readonly CartService $cartService) {}

    public function handle(CartItem $cartItem)
    {
        $this->cartService->removeItem($cartItem);
    }

    /**
     * use product to get cart item
     */
    public function usingProduct(Product $product)
    {
        $cartItem = $this->cartService->findCartItemByProduct($product);

        if (!$cartItem) {
            throw new ApiException("Product not found in cart");
        }

        return $this->handle($cartItem);
    }
}

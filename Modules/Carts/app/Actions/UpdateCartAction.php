<?php

namespace Modules\Carts\Actions;

use Modules\Carts\Models\CartItem;
use Modules\Carts\Services\CartService;
use Modules\Products\Models\Product;

class UpdateCartAction
{
    public function __construct(public readonly CartService $cartService) {}

    public function handle(CartItem $cartItem, int $quantity)
    {
        if ($quantity < 1) {
            throw new \Exception("Quantity must be at least 1");
        }

        if ($cartItem->product->stock < $quantity) {
            throw new \Exception(
                "Product is out of stock, you can not add more than " .
                    $cartItem->product->stock
            );
        }

        $this->cartService->updateItemQuantity($cartItem, $quantity);
    }

    /**
     * use product to get cart item
     */
    public function usingProduct(Product $product, int $quantity)
    {
        $cartItem = $this->cartService->findCartItemByProduct($product);

        if (!$cartItem) {
            throw new \Exception("Product not found in cart");
        }

        return $this->handle($cartItem, $quantity);
    }
}

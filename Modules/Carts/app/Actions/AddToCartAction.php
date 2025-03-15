<?php

namespace Modules\Carts\Actions;

use Modules\Carts\Services\CartService;
use Modules\Products\Models\Product;

final class AddToCartAction
{
    public function __construct(public readonly CartService $cartService) {}

    public function handle(Product $product, int $quantity = 1)
    {
        if ($quantity < 1) {
            throw new \Exception("Quantity must be at least 1");
        }

        if ($product->stock < $quantity) {
            throw new \Exception(
                "Product is out of stock, you can not add more than " .
                    $product->stock
            );
        }

        $cartItem = $this->cartService->findCartItemByProduct($product);

        if ($cartItem) {
            $this->cartService->updateProductQuantity($product, $quantity);

            return;
        }

        $this->cartService->addItem($product, $quantity);
    }
}

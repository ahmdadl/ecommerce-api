<?php

namespace Modules\Carts\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Carts\Actions\AddToCartAction;
use Modules\Carts\Actions\RemoveFromCartAction;
use Modules\Carts\Actions\UpdateCartAction;
use Modules\Carts\Models\CartItem;
use Modules\Products\Models\Product;
use Modules\Carts\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(
        Request $request,
        CartService $cartService
    ): JsonResponse {
        return api()->success([
            "items" => $cartService->cart->items,
            "totals" => $cartService->cart->totals,
        ]);
    }

    public function add(
        Request $request,
        Product $product,
        AddToCartAction $action
    ): JsonResponse {
        $action->handle($product, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    public function update(
        Request $request,
        CartItem $cartItem,
        UpdateCartAction $action
    ): JsonResponse {
        $action->handle($cartItem, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    public function updateByProduct(
        Request $request,
        Product $product,
        UpdateCartAction $action
    ): JsonResponse {
        $action->usingProduct($product, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    public function remove(
        Request $request,
        CartItem $cartItem,
        RemoveFromCartAction $action
    ): JsonResponse {
        $action->handle($cartItem);

        return $this->index($request, $action->cartService);
    }

    public function removeByProduct(
        Request $request,
        Product $product,
        RemoveFromCartAction $action
    ): JsonResponse {
        $action->usingProduct($product);

        return $this->index($request, $action->cartService);
    }
}

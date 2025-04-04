<?php

namespace Modules\Wishlists\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Products\Models\Product;
use Modules\Wishlists\Actions\AddToWishlistAction;
use Modules\Wishlists\Models\WishlistItem;
use Modules\Wishlists\Services\WishlistService;
use Modules\Wishlists\Transformers\WishlistResource;

class WishlistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        Request $request,
        WishlistService $service
    ): JsonResponse {
        $wishlist = $service->wishlist;
        $wishlist->loadMissing(["items", "items.product"]);
        $wishlist->unsetRelation("wishlistable");

        return api()->record(new WishlistResource($wishlist));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        Request $request,
        Product $product,
        AddToWishlistAction $action
    ): JsonResponse {
        $action->handle($product);

        if ($request->boolean("withoutResponse")) {
            return api()->noContent();
        }

        return $this->index($request, $action->service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        WishlistItem $wishlistItem
    ): JsonResponse {
        wishlistService()->removeItem($wishlistItem);

        if ($request->boolean("withoutResponse")) {
            return api()->noContent();
        }

        return $this->index($request, wishlistService());
    }

    /**
     * Remove By Product
     */
    public function destroyByProduct(
        Request $request,
        WishlistItem $wishlistItem
    ): JsonResponse {
        wishlistService()->removeItem($wishlistItem);

        if ($request->boolean("withoutResponse")) {
            return api()->noContent();
        }

        return $this->index($request, wishlistService());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function clear(Request $request): JsonResponse
    {
        wishlistService()->clear();

        return $this->index($request, wishlistService());
    }
}

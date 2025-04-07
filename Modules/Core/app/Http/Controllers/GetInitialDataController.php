<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Carts\Transformers\CartResource;
use Modules\Guests\Models\Guest;
use Modules\Guests\Transformers\GuestResource;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\User;
use Modules\Users\Transformers\CustomerResource;
use Modules\Wishlists\Transformers\WishlistResource;

class GetInitialDataController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = [];

        // get current user or guest
        $user = $request->user();
        $isGuest = $user instanceof Guest;
        if ($isGuest) {
            /** @var Guest $user */
            $user->role = "guest";
        } else {
            /** @var User $user */
            $user->withRole = true;
        }
        $response["user"] = $isGuest
            ? new GuestResource($user)
            : new CustomerResource($user);

        // get current cart
        $user->cart?->loadMissing("items.product");
        $response["cart"] = $user->cart ? new CartResource($user->cart) : null;

        // get current wishlist
        $user->wishlist?->loadMissing("items.product");
        $response["wishlist"] = $user->wishlist
            ? new WishlistResource($user->wishlist)
            : null;

        return api()->success($response);
    }
}

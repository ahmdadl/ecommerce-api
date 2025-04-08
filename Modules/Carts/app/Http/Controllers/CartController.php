<?php

namespace Modules\Carts\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Addresses\Transformers\AddressResource;
use Modules\Carts\Actions\AddToCartAction;
use Modules\Carts\Actions\ApplyCartCouponAction;
use Modules\Carts\Actions\RemoveFromCartAction;
use Modules\Carts\Actions\UpdateCartAction;
use Modules\Carts\Models\CartItem;
use Modules\Carts\Transformers\CartResource;
use Modules\Payments\Transformers\PaymentMethodResource;
use Modules\Products\Models\Product;
use Modules\Carts\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Addresses\Http\Requests\CreateAddressRequest;
use Modules\Addresses\Models\Address;
use Modules\Carts\Actions\CreateCartAddressAction;
use Modules\Carts\Actions\ResetCartAction;
use Modules\Carts\Actions\SetCartAddressAction;
use Modules\Coupons\Actions\ValidateCouponAction;
use Modules\Coupons\Models\Coupon;
use Modules\Payments\Models\PaymentMethod;

class CartController extends Controller
{
    /**
     * get all cart details
     */
    public function index(
        Request $request,
        CartService $cartService
    ): JsonResponse {
        $cartService->cart->loadMissing([
            "coupon",
            "address",
            "items",
            "items.product",
        ]);

        $response = [];

        $response["cart"] = new CartResource($cartService->cart);

        $loadedArray = $request->array("with");

        if (in_array("addresses", $loadedArray)) {
            $response["addresses"] = AddressResource::collection(
                $addresses = Address::where("user_id", user()?->id)
                    ->with(["government", "city"])
                    ->get()
            );

            // check if cart has no address, then set default address or first
            if (!$cartService->cart->address) {
                $defaultAddress =
                    Address::default()->first() ?? Address::first();
                $defaultAddress && $cartService->setAddress($defaultAddress);
            }
        } else {
            if (!$cartService->cart->address) {
                $defaultAddress =
                    Address::default()->first() ?? Address::first();
                $defaultAddress && $cartService->setAddress($defaultAddress);
            }
        }

        if (in_array("paymentMethods", $loadedArray)) {
            $response["paymentMethods"] = PaymentMethodResource::collection(
                PaymentMethod::active()->get()
            );
        }

        return api()->success($response);
    }

    /**
     * add product to cart
     */
    public function add(
        Request $request,
        Product $product,
        AddToCartAction $action
    ): JsonResponse {
        $action->handle($product, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    /**
     * update cart item
     */
    public function update(
        Request $request,
        CartItem $cartItem,
        UpdateCartAction $action
    ): JsonResponse {
        $action->handle($cartItem, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    /**
     * update cart product
     */
    public function updateByProduct(
        Request $request,
        Product $product,
        UpdateCartAction $action
    ): JsonResponse {
        $action->usingProduct($product, $request->integer("quantity", 1));

        return $this->index($request, $action->cartService);
    }

    /**
     * remove item from cart
     */
    public function remove(
        Request $request,
        CartItem $cartItem,
        RemoveFromCartAction $action
    ): JsonResponse {
        $action->handle($cartItem);

        return $this->index($request, $action->cartService);
    }

    /**
     * remove product from cart
     */
    public function removeByProduct(
        Request $request,
        Product $product,
        RemoveFromCartAction $action
    ): JsonResponse {
        $action->usingProduct($product);

        return $this->index($request, $action->cartService);
    }

    /**
     * set cart address
     */
    public function setCartAddress(
        Request $request,
        Address $address,
        SetCartAddressAction $action
    ): JsonResponse {
        $action->handle($address);

        return $this->index($request, $action->cartService);
    }

    /**
     * remove cart address
     */
    public function removeCartAddress(
        Request $request,
        CartService $cartService
    ): JsonResponse {
        $cartService->removeAddress();

        return $this->index($request, $cartService);
    }

    /**
     * set cart coupon
     */
    public function applyCartCoupon(
        Request $request,
        Coupon $coupon,
        ApplyCartCouponAction $action
    ): JsonResponse {
        $action->handle($coupon);

        return $this->index($request, $action->cartService);
    }

    /**
     * remove cart coupon
     */
    public function removeCartCoupon(
        Request $request,
        CartService $cartService
    ): JsonResponse {
        $cartService->removeCoupon();

        return $this->index($request, $cartService);
    }

    /**
     * reset cart
     */
    public function reset(
        Request $request,
        ResetCartAction $resetAction
    ): JsonResponse {
        $resetAction->handle();

        return $this->index($request, $resetAction->cartService);
    }

    /**
     * create address and set as cart address
     */
    public function createCartAddress(
        CreateAddressRequest $request,
        CreateCartAddressAction $action
    ): JsonResponse {
        $action->handle($request->validated());

        return $this->index($request, $action->cartService);
    }
}

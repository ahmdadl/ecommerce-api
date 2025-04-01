<?php

namespace Modules\Users\Enums;

enum UserTotalsKey: string
{
    use \Modules\Core\Traits\HasEnumHelpers;

    case CART_ITEMS = "cart_items";
    case WISHLIST_ITEMS = "wishlist_items";
    case COMPARE_ITEMS = "compare_items";

    case ORDERS = "orders";
    case PURCHASED = "purchased";
}

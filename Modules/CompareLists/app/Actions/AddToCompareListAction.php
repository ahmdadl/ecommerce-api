<?php

namespace Modules\CompareLists\Actions;

use Modules\Core\Exceptions\ApiException;
use Modules\Products\Models\Product;

class AddToCompareListAction extends BaseCompareListAction
{
    public function handle(Product $product): void
    {
        if ($this->service->count() >= 4) {
            throw new ApiException(__("compareLists::t.list_is_full"));
        }

        if ($this->service->hasProduct($product)) {
            throw new ApiException(
                __("compareLists::t.product_already_in_list")
            );
        }

        $this->service->addItem($product);
    }
}

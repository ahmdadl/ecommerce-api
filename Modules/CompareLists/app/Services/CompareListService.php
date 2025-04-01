<?php

namespace Modules\CompareLists\Services;

use Illuminate\Support\Facades\DB;
use Modules\CompareLists\Models\CompareList;
use Modules\CompareLists\Models\CompareListItem;
use Modules\Products\Models\Product;
use Modules\Users\Enums\UserTotalsKey;
use Modules\Users\ValueObjects\UserTotals;

final readonly class CompareListService
{
    /**
     * Initialize
     */
    public function __construct(public CompareList $compareList)
    {
        //
    }

    /**
     * Adds a specified quantity of a product to the compare list, creating a new Compare list item entry in the database.
     */
    public function addItem(Product $product): void
    {
        DB::transaction(function () use ($product) {
            CompareListItem::create([
                "compare_list_id" => $this->compareList->id,
                "product_id" => $product->id,
            ]);

            $this->save();
        });
    }

    /**
     * Removes a specified Compare list item from the compare list.
     */
    public function removeItem(CompareListItem $compareListItem): void
    {
        DB::transaction(function () use ($compareListItem) {
            $this->compareList
                ->items()
                ->where("id", $compareListItem->id)
                ->delete();
            $this->save();
        });
    }

    /**
     * clear compare list
     */
    public function clear(): void
    {
        DB::transaction(function () {
            $this->compareList->items()->delete();
            $this->save();
        });
    }

    /**
     * count of items
     */
    public function count(): int
    {
        return $this->compareList->items()->count();
    }

    /**
     * check if compare list is empty
     */
    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * check if product is in compare list
     */
    public function hasProduct(Product $product): bool
    {
        return $this->compareList
            ->items()
            ->where("product_id", $product->id)
            ->exists();
    }

    /**
     * update user total compare list items
     */
    public function updateUserTotalCompareListItems(): void
    {
        /** @var \Modules\Users\Models\User $this->compareList->compare_listable */
        UserTotals::update(
            $this->compareList->user,
            UserTotalsKey::COMPARE_ITEMS,
            $this->count()
        );
    }

    /**
     * save compare list
     */
    private function save(): void
    {
        $this->compareList->save();

        $this->updateUserTotalCompareListItems();
    }
}

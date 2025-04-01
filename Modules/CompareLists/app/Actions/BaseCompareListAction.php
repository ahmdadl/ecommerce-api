<?php

namespace Modules\CompareLists\Actions;

use Modules\CompareLists\Services\CompareListService;

abstract class BaseCompareListAction
{
    public function __construct(public readonly CompareListService $service) {}

    /**
     * create new wishlist action
     */
    public static function new(): static
    {
        return new static(app(CompareListService::class));
    }
}

<?php

use Modules\Brands\Models\Brand;
use Modules\Categories\Models\Category;
use Modules\Core\Actions\GetSpaCachedDataAction;

it("get spa cached data", function () {
    $categories = Category::factory(3)->create();
    $brands = Brand::factory(2)->create();

    $action = new GetSpaCachedDataAction();
    $result = $action->handle();

    expect($result)->toBeString();
    expect($result)->toContain(
        $categories->last()->title,
        $brands->last()->title
    );
});

<?php

namespace Modules\Core\Mixins;

final class BlueprintMixins
{
    /**
     * Add meta tags columns to the table.
     *
     * @return \Closure
     */
    public function metaTags()
    {
        return function () {
            $this->json("meta_title")->nullable();
            $this->json("meta_description")->nullable();
            $this->text("meta_keywords")->nullable();
        };
    }

    /**
     * Add an 'is_active' boolean column to indicate active state.
     *
     * @return \Closure
     */
    public function activeState()
    {
        return fn() => $this->boolean("is_active")->default(true);
    }

    /**
     * Add a 'sort_order' integer column with default value 1.
     *
     * @return \Closure
     */
    public function sortOrder()
    {
        return fn() => $this->integer("sort_order", false)->default(1);
    }
}

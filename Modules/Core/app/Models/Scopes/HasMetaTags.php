<?php

namespace Modules\Core\Models\Scopes;

trait HasMetaTags
{
    /**
     * initialize trait
     *
     * @return void
     */
    public function initializeHasMetaTags()
    {
        $this->translatable = array_merge($this->translatable, [
            "meta_title",
            "meta_description",
        ]);

        $this->casts = array_merge($this->casts, ["meta_keywords" => "array"]);
    }
}

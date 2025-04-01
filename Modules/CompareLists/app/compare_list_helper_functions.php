<?php

if (!function_exists("compareListService")) {
    /**
     * @return \Modules\CompareLists\Services\CompareListService
     */
    function compareListService(): \Modules\CompareLists\Services\CompareListService
    {
        return app(\Modules\CompareLists\Services\CompareListService::class);
    }
}

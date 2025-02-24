<?php

use Modules\Core\Utils\ApiResponse;

if (!function_exists("api")) {
    /**
     * api response
     * @return ApiResponse
     */
    function api()
    {
        return app(ApiResponse::class);
    }
}

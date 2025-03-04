<?php

use Modules\Core\Utils\ApiResponse;
use Modules\Users\Models\User;

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

if (!function_exists("user")) {
    /**
     * get current user
     */
    function user(string $guard = null): ?User
    {
        return auth()->guard($guard)->user();
    }
}

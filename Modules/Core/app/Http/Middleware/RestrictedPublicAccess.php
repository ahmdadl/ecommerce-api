<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictedPublicAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $secret = $request->header("X-PUBLIC-TOKEN");
        $validSecret = env("AUTH_PUBLIC_TOKEN", "your-secret-key");

        if ($secret !== $validSecret) {
            return api()->unauthorized("Invalid token");
        }

        return $next($request);
    }
}

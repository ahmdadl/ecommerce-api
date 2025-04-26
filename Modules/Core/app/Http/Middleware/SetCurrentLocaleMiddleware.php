<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Exceptions\ApiException;

class SetCurrentLocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header("locale-code");

        if (!in_array($locale, config("app.supported_locales"))) {
            throw new ApiException("Locale is not supported");
        }

        app()->setLocale($locale);

        return $next($request);
    }
}

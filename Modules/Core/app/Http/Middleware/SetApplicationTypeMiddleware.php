<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Services\Application;

class SetApplicationTypeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $applicationType = $request->header(Application::APPLICATION_HEADER);

        abort_if(empty($applicationType), 400, 'Missing required header: ' . Application::APPLICATION_HEADER);

        Application::setApplicationType($applicationType);

        return $next($request);
    }
}

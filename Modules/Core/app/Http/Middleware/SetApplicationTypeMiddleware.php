<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Exceptions\ApiException;
use Modules\Core\Services\Application;

class SetApplicationTypeMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (app()->runningUnitTests() || app()->runningInConsole()) {
            return $next($request);
        }

        $applicationType = $request->header(Application::APPLICATION_HEADER);

        if (empty($applicationType)) {
            throw new ApiException("Missing required header: application-type");
        }

        if (
            !in_array($applicationType, Application::getSupportedApplications())
        ) {
            throw new ApiException("Application type is not supported");
        }

        Application::setApplicationType($applicationType);

        return $next($request);
    }
}

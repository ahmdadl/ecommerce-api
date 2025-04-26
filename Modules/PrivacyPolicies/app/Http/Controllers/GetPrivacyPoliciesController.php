<?php

namespace Modules\PrivacyPolicies\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Modules\PrivacyPolicies\Models\PrivacyPolicy;
use Modules\PrivacyPolicies\Transformers\PrivacyPolicyResource;

class GetPrivacyPoliciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __invoke(): JsonResponse
    {
        $privacyPolicies = Cache::rememberForever(
            "api_privacy_policies",
            fn() => PrivacyPolicy::active()->orderBySortOrder()->get()
        );

        return api()->records(
            PrivacyPolicyResource::collection($privacyPolicies)
        );
    }
}

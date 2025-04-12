<?php

namespace Modules\ContactUs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\ContactUs\Http\Requests\StoreContactUsRequest;
use Modules\ContactUs\Models\ContactUsMessage;

class StoreContactUsMessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreContactUsRequest $request): JsonResponse
    {
        ContactUsMessage::create($request->validated());

        return api()->noContent();
    }
}

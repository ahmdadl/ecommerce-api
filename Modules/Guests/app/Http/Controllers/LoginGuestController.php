<?php

namespace Modules\Guests\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Services\Application;
use Modules\Guests\Models\Guest;
use Modules\Guests\Transformers\GuestResource;

class LoginGuestController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var Guest $guest */
        $guest = Guest::create();

        $accessToken = $guest->createToken(Application::getApplicationType())
            ->plainTextToken;

        $guest->access_token = $accessToken;

        return api()->success([
            "record" => new GuestResource($guest),
        ]);
    }
}

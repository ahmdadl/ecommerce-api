<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Actions\LoginUserAction;
use Modules\Users\Actions\RegisterUserAction;
use Modules\Users\Http\Requests\LoginUserRequest;
use Modules\Users\Http\Requests\RegisterUserRequest;
use Modules\Users\Transformers\CustomerResource;

class AuthUserController extends Controller
{
    public function login(LoginUserRequest $request, LoginUserAction $action): JsonResponse
    {
        $user = $action->handle($request->validated());

        if (!$user) {
            return api()->unauthorized(__('users::user.invalid_credentials'));
        }

        return api()->success([
            'record' => new CustomerResource($user),
        ]);
    }

    public function register(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        $user = $action->handle($request->validated());

        return api()->success([
            'record' => new CustomerResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return api()->success();
    }
}

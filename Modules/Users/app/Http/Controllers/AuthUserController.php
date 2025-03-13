<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Users\Actions\Auth\LoginUserAction;
use Modules\Users\Actions\Auth\RegisterUserAction;
use Modules\Users\Actions\Auth\UserForgetPasswordAction;
use Modules\Users\Actions\Auth\UserResetPasswordAction;
use Modules\Users\Http\Requests\Auth\LoginUserRequest;
use Modules\Users\Http\Requests\Auth\RegisterUserRequest;
use Modules\Users\Http\Requests\Auth\UserResetPasswordRequest;
use Modules\Users\Transformers\CustomerResource;

class AuthUserController extends Controller
{
    /**
     * log use in
     */
    public function login(
        LoginUserRequest $request,
        LoginUserAction $action
    ): JsonResponse {
        $user = $action->handle($request->validated());

        if (!$user) {
            return api()->unauthorized(__("users::user.invalid_credentials"));
        }

        return api()->success([
            "record" => new CustomerResource($user),
        ]);
    }

    /**
     * register user
     */
    public function register(
        RegisterUserRequest $request,
        RegisterUserAction $action
    ): JsonResponse {
        $user = $action->handle($request->validated());

        return api()->success([
            "record" => new CustomerResource($user),
        ]);
    }

    /**
     * forget user password
     */
    public function forgetPassword(
        Request $request,
        UserForgetPasswordAction $action
    ): JsonResponse {
        ["email" => $email] = $request->validate([
            "email" => "required|email|max:150",
        ]);

        $sent = $action->handle($email);

        if (!$sent) {
            return api()->error(__("users::user.email_not_found"));
        }

        return api()->noContent();
    }

    /**
     * reset user password
     */
    public function resetPassword(
        UserResetPasswordRequest $request,
        UserResetPasswordAction $action
    ): JsonResponse {
        try {
            $action->handle($request->validated());
        } catch (\Exception $e) {
            return api()->error($e->getMessage());
        }

        return api()->noContent();
    }
}

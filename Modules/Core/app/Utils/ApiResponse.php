<?php

namespace Modules\Core\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

final class ApiResponse
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     */
    public function success(
        $data = null,
        ?string $message = null,
        int $statusCode = 200
    ): JsonResponse {
        return response()->json(
            [
                "success" => true,
                "message" => $message ?? __("core::core.success"),
                "data" => $data,
            ],
            $statusCode
        );
    }

    /**
     * Return an error JSON response.
     */
    public function error(
        ?string $message = null,
        int $statusCode = 400,
        array $errors = []
    ): JsonResponse {
        return response()->json(
            [
                "success" => false,
                "message" => $message ?? __("core::core.error"),
                "errors" => $errors,
            ],
            $statusCode
        );
    }

    /**
     * Return a paginated JSON response.
     *
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @param \Illuminate\Pagination\LengthAwarePaginator<TModel> $paginator
     * @param ?string $message
     * @return JsonResponse
     */
    public function paginate(
        LengthAwarePaginator $paginator,
        ?string $message = null
    ): JsonResponse {
        return response()->json([
            "success" => true,
            "message" => $message ?? __("core::core.pagination_success"),
            "data" => $paginator->items(),
            "pagination" => [
                "total" => $paginator->total(),
                "per_page" => $paginator->perPage(),
                "current_page" => $paginator->currentPage(),
                "last_page" => $paginator->lastPage(),
                "from" => $paginator->firstItem(),
                "to" => $paginator->lastItem(),
            ],
        ]);
    }

    /**
     * Return a success JSON response with no data.
     */
    public function noContent(
        ?string $message = null,
        int $statusCode = 204
    ): JsonResponse {
        return response()->json(
            [
                "success" => true,
                "message" => $message ?? __("core::core.empty_success"),
            ],
            $statusCode
        );
    }

    /**
     * Return a validation error JSON response.
     */
    public function validationError(
        array $errors,
        ?string $message = null
    ): JsonResponse {
        return $this->error(
            $message ?? __("core::core.validation_error"),
            422,
            $errors
        );
    }

    /**
     * Return a not found JSON response.
     */
    public function notFound(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __("core::core.not_found"), 404);
    }

    /**
     * Return an unauthorized JSON response.
     */
    public function unauthorized(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __("core::core.unauthorized"), 401);
    }

    /**
     * Return a forbidden JSON response.
     */
    public function forbidden(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __("core::core.forbidden"), 403);
    }

    /**
     * Return a server error JSON response.
     */
    public function serverError(?string $message = null): JsonResponse
    {
        return $this->error($message ?? __("core::core.server_error"), 500);
    }

    /**
     * Return a record JSON response.
     *
     * @param  mixed  $record
     */
    public function record($record, ?string $message = null): JsonResponse
    {
        return $this->success(compact("record"), $message);
    }

    /**
     * Return a records JSON response.
     *
     * @param  mixed  $records
     */
    public function records($records, ?string $message = null): JsonResponse
    {
        return $this->success(compact("records"), $message);
    }
}

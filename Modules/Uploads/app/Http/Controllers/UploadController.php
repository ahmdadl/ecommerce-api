<?php

namespace Modules\Uploads\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Uploads\Actions\ShowUploadAction;
use Modules\Uploads\Actions\StoreUploadAction;
use Modules\Uploads\Models\Upload;
use Modules\Uploads\Transformers\UploadResource;

class UploadController extends Controller
{
    /**
     * store uploaded file
     */
    public function store(
        Request $request,
        StoreUploadAction $action
    ): JsonResponse {
        $request->validate([
            "file" => "required|file|mimes:png,jpg,jpeg,webp,pdf|max:3024", // 3MB
        ]);

        $upload = $action->handle($request->file("file"));

        return api()->record(new UploadResource($upload));
    }

    /**
     * get uploaded file
     */
    public function show(
        Request $request,
        Upload $upload,
        ShowUploadAction $action
    ): mixed {
        try {
            $result = $action->handle($upload);

            // Return the file content with the appropriate MIME type
            return response($result["content"], 200)->header(
                "Content-Type",
                $result["mime_type"]
            );
        } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
            return $request->wantsJson()
                ? api()->notFound($e->getMessage())
                : abort(404, $e->getMessage());
        }
    }
}

<?php

namespace Modules\Core\Utils;

use Illuminate\Http\UploadedFile;
use Modules\Uploads\Actions\StoreUploadAction;

class FilamentUtils
{
    public static function storeSingleFile($state): ?string
    {
        if (is_array($state)) {
            /** @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file */
            $file = $state[array_key_first($state)];

            $action = new StoreUploadAction();

            $fileRecord = $action->handle(
                new UploadedFile(
                    $file->path(),
                    $file->getClientOriginalName(),
                    $file->getMimeType()
                )
            );

            // delete temp file
            $file->delete();

            return $fileRecord->id;
        }

        return null;
    }
}

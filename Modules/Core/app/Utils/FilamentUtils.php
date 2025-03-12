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

            return static::storeTempFile($file);
        }

        return null;
    }

    /**
     * store multiple file
     */
    public static function storeMultipleFile($state): ?array
    {
        if (!is_array($state)) {
            return null;
        }

        $files = $state;

        return array_map(function ($file) {
            return static::storeTempFile($file);
        }, $files);
    }

    /**
     * store temp file
     */
    public static function storeTempFile(
        \Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file
    ): string {
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
}

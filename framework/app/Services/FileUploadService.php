<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public static function simpanPublik(UploadedFile $file, string $folder = 'items'): string
    {
        return $file->store($folder, 'public');
    }

    public static function simpanPrivat(UploadedFile $file, string $folder = 'evidence'): string
    {
        return $file->store($folder, 'local');
    }

    public static function hapus(?string $path, bool $privat = false): bool
    {
        if (!$path) {
            return false;
        }

        $disk = $privat ? 'local' : 'public';
        return Storage::disk($disk)->delete($path);
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class FileUploadService
{
    public const MAX_FILE_SIZE_BYTES = 2097152; // 2 MB (2 * 1024 * 1024)
    public const MAX_IMAGE_WIDTH = 1280;

    /**
     * Menyimpan file ke disk publik (public/storage) dengan resize otomatis via GD jika gambar > 1280 px.
     */
    public function simpanPublik(UploadedFile $file, string $folder = 'items'): string
    {
        $this->validasiUkuran($file);

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::random(40) . ($extension ? '.' . $extension : '');
        $path = trim($folder, '/') . '/' . $filename;

        // Cek apakah file adalah gambar yang didukung untuk resize GD
        $mime = $file->getMimeType();
        if (str_starts_with($mime, 'image/') && in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $resizedContent = $this->resizeGambarJikaPerlu($file->getRealPath(), $extension);
            if ($resizedContent !== null) {
                Storage::disk('public')->put($path, $resizedContent);
                return $path;
            }
        }

        // Simpan langsung jika bukan gambar atau tidak perlu resize
        Storage::disk('public')->putFileAs($folder, $file, $filename);

        return $path;
    }

    /**
     * Menyimpan file ke disk privat (local private storage, tidak dapat diakses publik).
     */
    public function simpanPrivat(UploadedFile $file, string $folder = 'evidences'): string
    {
        $this->validasiUkuran($file);

        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::random(40) . ($extension ? '.' . $extension : '');

        return Storage::disk('local')->putFileAs($folder, $file, $filename);
    }

    /**
     * Menghapus file dari disk yang ditentukan.
     */
    public function hapus(string $path, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    /**
     * Validasi batas ukuran file (maksimal 2 MB).
     */
    protected function validasiUkuran(UploadedFile $file): void
    {
        if ($file->getSize() > self::MAX_FILE_SIZE_BYTES) {
            throw new InvalidArgumentException('Ukuran file melebihi batas maksimal 2 MB.');
        }
    }

    /**
     * Melakukan resize gambar jika lebarnya melebihi 1280 px menggunakan GD extension.
     */
    protected function resizeGambarJikaPerlu(string $filePath, string $extension): ?string
    {
        if (! extension_loaded('gd')) {
            return null;
        }

        $imageInfo = @getimagesize($filePath);
        if (! $imageInfo) {
            return null;
        }

        [$width, $height] = $imageInfo;

        if ($width <= self::MAX_IMAGE_WIDTH) {
            return null;
        }

        // Hitung rasio aspek baru
        $ratio = self::MAX_IMAGE_WIDTH / $width;
        $newWidth = self::MAX_IMAGE_WIDTH;
        $newHeight = (int) round($height * $ratio);

        $sourceImage = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($filePath),
            'png' => @imagecreatefrompng($filePath),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($filePath) : null,
            'gif' => @imagecreatefromgif($filePath),
            default => null,
        };

        if (! $sourceImage) {
            return null;
        }

        $targetImage = imagecreatetruecolor($newWidth, $newHeight);

        // Pertahankan transparansi untuk PNG dan WebP
        if (in_array($extension, ['png', 'webp', 'gif'], true)) {
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
            imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start();
        match ($extension) {
            'jpg', 'jpeg' => imagejpeg($targetImage, null, 85),
            'png' => imagepng($targetImage, 8),
            'webp' => function_exists('imagewebp') ? imagewebp($targetImage, null, 85) : imagejpeg($targetImage, null, 85),
            'gif' => imagegif($targetImage),
            default => imagejpeg($targetImage, null, 85),
        };
        $output = ob_get_clean();

        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return $output ?: null;
    }
}

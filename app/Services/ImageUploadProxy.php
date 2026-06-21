<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadProxy
{
    public function __construct() {}

    public function upload(UploadedFile $file, string $folder, int $width, int $height, string $method = 'resize', ?string $filename = null): string
    {
        $filename ??= hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
        $dir = public_path($folder);

        File::ensureDirectoryExists($dir);

        $manager = new ImageManager(new Driver);
        $img = $manager->read($file);

        if ($method === 'cover') {
            $img->cover($width, $height);
        } else {
            $img->resize($width, $height);
        }

        $img->save($dir . '/' . $filename);

        return $filename;
    }

    public function move(UploadedFile $file, string $folder, ?string $filename = null): string
    {
        $filename ??= hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
        $dir = public_path($folder);

        File::ensureDirectoryExists($dir);

        $file->move($dir, $filename);

        return $filename;
    }

    public function delete(string $path): void
    {
        if ($path && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
    }
}

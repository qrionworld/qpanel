<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public static function thumbnail($path, $width = 200, $height = 150)
    {
        if (!$path || !Storage::exists($path)) {
            return null;
        }

        $thumbPath = 'thumbnails/' . $width . 'x' . $height . '/' . basename($path);

        if (!Storage::exists($thumbPath)) {
            $image = Image::make(Storage::get($path))
                        ->fit($width, $height)
                        ->encode();
            Storage::put($thumbPath, (string) $image);
        }

        return Storage::url($thumbPath);
    }
}

<?php

namespace Support\testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class FakerImageProvider extends Base
{
    public function loremfrickr(string $dir = '', int $width = 500, int $height = 500): string
    {
        $name = $dir . '/'. Str::random(10).'.jpg';

        Storage::put(
            $name,
            file_get_contents("https://loremflickr.com/$width/$height")
        );

        return '/storage/'.$name;
    }
}

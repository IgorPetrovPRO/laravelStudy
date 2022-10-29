<?php

namespace App\Faker;

use Faker\Provider\File;
use Illuminate\Support\Facades\Storage;


final class FakerImageLocalProvider extends File
{
    public function fileFixtures(string $pathIn, string $pathOut):string
    {
        if(!Storage::exists($pathOut)){
            Storage::makeDirectory($pathOut);
        }

        $fileName = self::file('tests/Fixtures/images/'.$pathIn,Storage::path($pathOut),false);

        if(is_file(Storage::path($pathOut).$fileName)){
            return $pathOut.$fileName;
        }else{
            throw new \Exception('this is not a file');
        }

    }
}

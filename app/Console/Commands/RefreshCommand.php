<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RefreshCommand extends Command
{
    protected $signature = 'shop:refresh';

    protected $description = 'Install Shop from Zero';

    public function handle(): int
    {
        if(app()->isProduction()){
            return  self::FAILURE;
        }
        Storage::deleteDirectory('images/products');
        Storage::deleteDirectory('images/brands');
        $this->call('migrate:fresh',[
            '--seed'=> true,
        ]);



        return self::SUCCESS;
    }
}

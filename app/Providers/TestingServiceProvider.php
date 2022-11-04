<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\ServiceProvider;
use Support\testing\FakerImageLocalProvider;

class TestingServiceProvider extends ServiceProvider
{
    public function register() :void
    {
        $this->app->singleton(Generator::class,function (){
            $faker = Factory::create();
            $faker->addProvider(new FakerImageLocalProvider($faker));
            return $faker;
        });
    }

    public function boot() :void

    {
    }
}

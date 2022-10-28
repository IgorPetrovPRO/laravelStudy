<?php

namespace App\Providers;

use App\Faker\FakerImageLocalProvider;
use App\Faker\FakerImageProvider;
use App\Http\Kernel;
use Carbon\CarbonInterval;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Generator::class,function (){
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));
            $faker->addProvider(new FakerImageLocalProvider($faker));
            return $faker;
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        if(app()->isProduction()){
            DB::listen(function ($query){
                //dump($query->sql);
                if($query->time > 500){
                    logger()
                        ->channel('telegram')
                        ->debug('query longer that 5ms:' . $query->sql, $query->bindings);
                }
            });

            $kernel = app(Kernel::class);
            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::second(4),
                function (){
                    logger()
                        ->channel('telegram')
                        ->debug('whenRequestLifecycleIsLongerThan:' . request()->url());
                }
            );
        }
    }
}

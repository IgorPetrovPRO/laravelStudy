<?php

namespace Domain\Auth\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];


    public function boot()
    {
        //$this->registerPolicies();
        //
    }

    public function register()
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }

}

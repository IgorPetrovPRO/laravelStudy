<?php

namespace Domain\Auth\Providers;

use Domain\Auth\Actions\RegisterNewUserAction;
use Domain\Auth\Actions\RegisterNewUserContract;
use Illuminate\Support\ServiceProvider;


class ActionsServiceProvider extends ServiceProvider
{
    public  array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class
    ];

}

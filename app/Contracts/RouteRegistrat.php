<?php

namespace App\Contracts;

use Illuminate\Contracts\Routing\Registrar;

interface RouteRegistrat
{
    public function map(Registrar $registrar):void;
}

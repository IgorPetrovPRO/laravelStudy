<?php

namespace Domain\Auth\Actions;

use Domain\Auth\DTOs\NewUserDTO;

interface RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data);
}

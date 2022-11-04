<?php

namespace Domain\Auth\Actions;

interface RegisterNewUserContract
{
    public function __invoke(string $name, string $email, string $password);
}

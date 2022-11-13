<?php

namespace Auth\Actions;

use Domain\Auth\Actions\RegisterNewUserContract;
use Domain\Auth\DTOs\NewUserDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterNewUserActionTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_success_user_created():void
    {
        $this->assertDatabaseMissing('users',[
            'email' => 'i.petrov@creative-lab.pro',
        ]);
        $action = app(RegisterNewUserContract::class);
        $action(NewUserDTO::make('Test','i.petrov@creative-lab.pro','12345678'));
        $this->assertDatabaseHas('users',[
            'email' => 'i.petrov@creative-lab.pro',
        ]);
    }
}

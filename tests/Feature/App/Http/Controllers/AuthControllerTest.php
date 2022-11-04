<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_is_login_page():void
    {
        $this->get(action([SignInController::class,'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');

    }

    public function test_is_signup_page():void
    {
        $this->get(action([SignUpController::class,'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');

    }

    public function test_is_signin_success():void
    {
        $password = '123456789';
        $user = UserFactory::new()->create([
            'email' => 'info@ipetrov.pro',
            'password' => bcrypt($password)
        ]);
        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password,
        ]);

        $response = $this->post(action([SignInController::class,'handle'],$request));
        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_is_logout_success():void
    {
        $user = UserFactory::new()->create([
            'email' => 'info@ipetrov.pro',
        ]);

        $this->actingAs($user)->delete(action([SignInController::class,'logout']));

        $this->assertGuest();
    }


    public function test_is_forgot_page():void
    {
        $this->get(action([ForgotPasswordController::class,'page']))
            ->assertOk()
            ->assertSee('Забыл пароль')
            ->assertViewIs('auth.forgot-password');

    }

    public function test_is_reset_page():void
    {
        $token = '123123123';
        $this->get(action([ResetPasswordController::class,'page'], $token))
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }
    //TODO описатиь проверку
//    public function test_is_reset_success():void
//    {
//
//    }

    public function test_is_sign_up_success(): void
    {
        Notification::fake();
        Event::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@ipetrov.pro',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        //Можно указать не action a route
        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request,
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        $user = User::where('email', '=', $request['email'])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }
}

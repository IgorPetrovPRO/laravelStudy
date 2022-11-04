<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Throwable;


class SocialAuthController extends Controller
{

    protected $driver = 'github';


    public function redirect(string $driver) : RedirectResponse
    {

        try {
            return Socialite::driver($driver)->redirect();
        }catch (Throwable $e){
            throw new DomainException('Error no driver');
        }

    }

    public function callback(string $driver){

        if($driver !== 'github'){
            throw new DomainException('Error no driver '. $driver);
        }
        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver.'_id' => $githubUser->id,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password' => bcrypt(str()->random(10)),
        ]);

        auth()->login($user);

        return redirect()->intended(route('home'));
    }
}

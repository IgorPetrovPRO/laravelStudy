<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\SignInFormRequest;

use Illuminate\Http\RedirectResponse;



class SignInController extends Controller
{
    public function page()
    {
        return view('auth.login');
    }

    public function handle(SignInFormRequest $request) :RedirectResponse
    {
        if(!auth()->attempt($request->validated())){
            return back()->withErrors([
                'email' => 'Скорректируйте емайл',
            ])->onlyInput('email');
        }
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout() : RedirectResponse
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('auth.register', [
            'title' => 'PerPusKu - Register',
        ]);
    }

    public function login(): View
    {
        return view('auth.login', [
            'title' => 'PerPusKu - Login',
        ]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        $credentials['email'] = Str::lower(trim($credentials['email']));

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            Auth::guard('web')->logout();
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            Auth::guard('admin')->logout();
            $request->session()->regenerate();

            return redirect()->route('user.dashboard');
        }

        return back()
            ->withErrors(['email' => 'Email atau kata sandi tidak valid.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(): View
    {
        return view('auth.register', [
            'title' => 'PerPusKu - Register',
        ]);
    }

    public function login()
    {
        return view('auth.login', [
            'title' => 'PerPusKu - Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $username = strtolower(trim($request->input('username', '')));

        if ($username === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('landing');
    }

    public function logout()
    {
        return 'Proses logout';
    }
}

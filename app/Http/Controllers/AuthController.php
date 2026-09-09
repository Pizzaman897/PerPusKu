<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth.login', [
            'title' => 'PerPusKu - Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        return "Proses login";
    }

    public function logout()
    {
        return "Proses logout";
    }
}
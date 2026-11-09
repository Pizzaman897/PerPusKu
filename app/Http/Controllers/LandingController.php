<?php

namespace App\Http\Controllers;

class LandingController extends Controller
{
    public function index()
    {
        return view('landing.landing', [
            'title' => 'PerPusKu - Perpustakaan Digital',
        ]);
    }
}

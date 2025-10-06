<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function login() {
        return view('auth.login');
    }

    public function registration() {
        return view('auth.registration');
    }

    public function profile() {
        return view('profile');
    }
}

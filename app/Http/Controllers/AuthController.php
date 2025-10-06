<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('home');
        } else {
            return back()->withErrors([
                'error' => 'E-mail ou mot de passe invalide•s',
            ])->withInput();
        }
    }

    public function registration(RegistrationRequest $request)
    {
        $validatedData = $request->validate([

            'profile_picture' => 'nullable|image|max:2048', // max 2MB
        ]);
        $file = $request->file('profile_picture');
        if ($file)
            $path = $file->store('users', 'public');

        User::create([
            'profile_picture' => $file ? $path : null,
            'name' => $request->name,
            // 'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', "Inscription réussie !");
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}

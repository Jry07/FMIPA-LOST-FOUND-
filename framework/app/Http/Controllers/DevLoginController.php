<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DevLoginController extends Controller
{
    /**
     * Login cepat berbasis peran untuk pengujian lokal (HANYA local environment).
     */
    public function login(string $role): RedirectResponse
    {
        if (! app()->environment('local')) {
            abort(404);
        }

        $email = match ($role) {
            'admin' => 'admin@fmipa.test',
            'petugas' => 'petugas@fmipa.test',
            'pengguna', 'user' => 'pengguna1@fmipa.test',
            default => null,
        };

        $user = $email ? User::where('email', $email)->first() : User::where('role', $role)->first();

        if (! $user) {
            return redirect()->route('home')->with('error', "User dengan peran '{$role}' tidak ditemukan.");
        }

        Auth::login($user);

        return redirect()->route($user->homeRoute())->with('success', "Berhasil login cepat sebagai [{$user->role}] {$user->name}.");
    }
}

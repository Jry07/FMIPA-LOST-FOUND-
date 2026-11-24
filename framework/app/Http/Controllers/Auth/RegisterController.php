<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Tampilkan formulir registrasi akun pengguna baru.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Simpan akun pengguna baru ke basis data.
     * Sesuai SRS FR-01:
     * - Role otomatis disetel ke User::ROLE_PENGGUNA (tidak mengambil dari input).
     * - Kata sandi di-hash menggunakan bcrypt.
     * - Redirect ke halaman login dengan pesan sukses.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $rolePengguna = defined(User::class . '::ROLE_PENGGUNA')
            ? User::ROLE_PENGGUNA
            : 'pengguna';

        User::create([
            'name' => trim($request->name),
            'email' => strtolower(trim($request->email)),
            'nim' => strtoupper(trim($request->nim)),
            'role' => $rolePengguna,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan masuk dengan akun Anda.');
    }
}

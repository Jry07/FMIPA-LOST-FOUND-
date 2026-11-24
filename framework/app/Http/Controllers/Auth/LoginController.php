<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

// [M2-AUTH]
class LoginController extends Controller
{
    /**
     * Tampilkan formulir masuk/login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function showLoginForm(): View
    {
        return $this->create();
    }

    /**
     * Proses autentikasi pengguna masuk ke sistem.
     * Sesuai SRS FR-02:
     * - Menggunakan Auth::attempt dengan opsi remember me.
     * - Regenerasi sesi setelah berhasil.
     * - Pesan kesalahan seragam jika gagal ('Email atau kata sandi salah').
     * - Redirect ke rute beranda peran masing-masing.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            $targetRoute = method_exists($user, 'homeRoute')
                ? $user->homeRoute()
                : match ($user->role ?? 'pengguna') {
                    'admin' => 'admin.dashboard',
                    'petugas' => 'petugas.dashboard',
                    default => 'home',
                };

            $redirectUrl = Route::has($targetRoute)
                ? route($targetRoute)
                : route('home');

            return redirect()->intended($redirectUrl);
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        return $this->store($request);
    }

    /**
     * Proses keluar/logout dari sistem.
     * Sesuai SRS FR-02:
     * - Menghapus sesi autentikasi.
     * - Invalidate session & regenerate CSRF token.
     * - Redirect ke halaman beranda publik.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function logout(Request $request): RedirectResponse
    {
        return $this->destroy($request);
    }
}
// [/M2-AUTH]

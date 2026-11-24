<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengelolaan profil pengguna.
     * Sesuai SRS FR-03: Email, NIM, dan role tampil sebagai read-only.
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    /**
     * Perbarui data profil pengguna (nama dan kata sandi).
     * Sesuai SRS FR-03:
     * - Pengguna dapat mengubah nama dan kata sandi.
     * - Kata sandi bersifat opsional; jika diisi, wajib verifikasi kata sandi lama.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->name = trim($request->name);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRoleRequest;
use App\Models\User;

// [M1-ADMIN]
class UserController extends Controller
{
    /**
     * Daftar semua akun pengguna dengan pencarian dan paginasi.
     */
    public function index()
    {
        $search = request('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Ubah peran (role) akun pengguna.
     * Admin tidak boleh mengubah role dirinya sendiri (dijaga di FormRequest).
     */
    public function updateRole(UpdateUserRoleRequest $request, User $user)
    {
        // Pengaman ganda: jangan ubah diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        $user->update(['role' => $request->validated('role')]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Peran akun {$user->name} berhasil diubah menjadi {$user->role}.");
    }
}
// [/M1-ADMIN]

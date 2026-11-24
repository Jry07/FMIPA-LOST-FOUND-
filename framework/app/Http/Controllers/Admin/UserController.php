<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// [M1-ADMIN]
class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.users.index')->with('success', 'Stub [M1-ADMIN]: Peran pengguna berhasil diperbarui.');
    }
}
// [/M1-ADMIN]

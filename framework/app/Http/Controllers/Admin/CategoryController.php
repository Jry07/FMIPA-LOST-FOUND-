<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// [M1-ADMIN]
class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Stub [M1-ADMIN]: Kategori berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return view('admin.categories.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('admin.categories.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Stub [M1-ADMIN]: Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        return redirect()->route('admin.categories.index')->with('success', 'Stub [M1-ADMIN]: Kategori berhasil dihapus.');
    }
}
// [/M1-ADMIN]

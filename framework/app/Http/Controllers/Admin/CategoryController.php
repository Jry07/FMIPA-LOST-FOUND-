<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;

// [M1-ADMIN]
class CategoryController extends Controller
{
    /**
     * Daftar semua kategori beserta jumlah laporan yang memakainya.
     */
    public function index()
    {
        $categories = Category::withCount('items')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Formulir tambah kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru ke database.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Formulir ubah kategori (tidak ada halaman show tersendiri per kontrak M1).
     */
    public function edit(Category $category)
    {
        $category->loadCount('items');

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Simpan perubahan kategori.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori, hanya jika tidak dipakai oleh laporan manapun.
     */
    public function destroy(Category $category)
    {
        $jumlahLaporan = $category->items()->count();

        if ($jumlahLaporan > 0) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Kategori masih dipakai oleh {$jumlahLaporan} laporan dan tidak dapat dihapus.");
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
// [/M1-ADMIN]

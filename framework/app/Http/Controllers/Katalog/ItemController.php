<?php

namespace App\Http\Controllers\Katalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Katalog\FilterItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Contracts\View\View;

class ItemController extends Controller
{
    /**
     * Menampilkan katalog daftar barang dengan pencarian dan filter (FR-05).
     *
     * Aturan:
     * - Akses hanya untuk user yang terautentikasi (middleware auth).
     * - Hanya memuat laporan berstatus dipublikasikan (default) atau selesai.
     * - 9 laporan per halaman dengan query string terjaga (NFR-01).
     * - Pengurutan terbaru berdasarkan waktu pelaporan.
     */
    public function index(FilterItemRequest $request): View
    {
        // Tentukan filter status: default adalah dipublikasikan (FR-05)
        $statusInput = $request->input('status');
        $status = ($statusInput === Item::STATUS_SELESAI)
            ? Item::STATUS_SELESAI
            : Item::STATUS_DIPUBLIKASIKAN;

        // Query builder dengan pemilihan kolom seperlunya dan eager loading (NFR-01)
        $query = Item::query()
            ->select([
                'id',
                'user_id',
                'category_id',
                'name',
                'type',
                'description',
                'photo',
                'location',
                'incident_date',
                'incident_time',
                'status',
                'created_at',
            ])
            ->with(['category:id,name'])
            ->where('status', $status);

        // Pencarian kata kunci q pada nama dan deskripsi (LIKE)
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        // Filter kategori barang
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter lokasi kejadian (pencarian teks LIKE)
        if ($request->filled('location')) {
            $loc = trim($request->input('location'));
            $query->where('location', 'like', "%{$loc}%");
        }

        // Filter jenis laporan (Semua / Hilang / Ditemukan)
        if ($request->filled('type') && in_array($request->input('type'), [Item::TYPE_LOST, Item::TYPE_FOUND], true)) {
            $query->where('type', $request->input('type'));
        }

        // Filter tanggal kejadian (rentang dari-sampai atau satu tanggal tertentu)
        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('incident_date', [
                $request->input('tanggal_dari'),
                $request->input('tanggal_sampai'),
            ]);
        } elseif ($request->filled('tanggal_dari')) {
            $query->whereDate('incident_date', '>=', $request->input('tanggal_dari'));
        } elseif ($request->filled('tanggal_sampai')) {
            $query->whereDate('incident_date', '<=', $request->input('tanggal_sampai'));
        } elseif ($request->filled('tanggal')) {
            $query->whereDate('incident_date', $request->input('tanggal'));
        }

        // Urutkan laporan terbaru dan batasi 9 per halaman (FR-05)
        $items = $query->latest('created_at')
            ->paginate(9)
            ->withQueryString();

        // Ambil daftar kategori untuk dropdown pilihan filter
        $categories = class_exists(Category::class)
            ? Category::orderBy('name')->get(['id', 'name'])
            : collect();

        return view('items.index', compact('items', 'categories'));
    }

    /**
     * Menampilkan detail informasi satu laporan barang (FR-05).
     *
     * Aturan Otorisasi:
     * - Status dipublikasikan dan selesai boleh dilihat oleh semua pengguna login.
     * - Status lain (menunggu, ditolak, dibatalkan) HANYA boleh dilihat oleh:
     *   1) Pemilik laporan itu sendiri,
     *   2) Admin, atau
     *   3) Petugas.
     * - Selain kondisi di atas, sistem menghasilkan abort(404).
     *
     * Privasi (NFR-05):
     * - Tidak menampilkan data kontak pribadi pelapor maupun bukti klaim ke publik.
     */
    public function show(Item $item): View
    {
        $user = auth()->user();

        $isPublic = in_array($item->status, [
            Item::STATUS_DIPUBLIKASIKAN,
            Item::STATUS_SELESAI,
        ], true);

        if (! $isPublic) {
            $isOwner = $user && ($user->id === $item->user_id);
            $isStaff = $user && in_array($user->role, [
                User::ROLE_ADMIN,
                User::ROLE_PETUGAS,
            ], true);

            if (! $isOwner && ! $isStaff) {
                abort(404);
            }
        }

        // Eager load category untuk tampilan informasi
        $item->loadMissing(['category']);

        return view('items.show', compact('item'));
    }
}

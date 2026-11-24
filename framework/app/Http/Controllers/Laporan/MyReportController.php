<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laporan\UpdateReportRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\FileUploadService;
use App\Services\StatusHistoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MyReportController extends Controller
{
    /**
     * Tampilkan daftar laporan milik pengguna yang sedang masuk.
     */
    public function index()
    {
        $userId = Auth::id();

        $reports = class_exists(Item::class)
            ? Item::where('user_id', $userId)
                ->with(['category', 'user'])
                ->latest()
                ->paginate(10)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);

        return view('reports.my-index', compact('reports'));
    }

    /**
     * Tampilkan formulir untuk mengubah laporan (hanya status menunggu).
     */
    public function edit($item)
    {
        $item = $item instanceof Item ? $item : Item::findOrFail($item);
        $user = Auth::user();

        $statusMenunggu = defined('App\Models\Item::STATUS_MENUNGGU')
            ? Item::STATUS_MENUNGGU
            : 'menunggu';

        // Otorisasi: hanya pemilik dan hanya jika status masih menunggu
        if ($item->user_id !== $user->id || $item->status !== $statusMenunggu) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah laporan ini.');
        }

        $categories = class_exists(Category::class)
            ? Category::orderBy('name')->get()
            : collect();

        return view('reports.edit', compact('item', 'categories'));
    }

    /**
     * Perbarui data laporan barang di database.
     */
    public function update(UpdateReportRequest $request, $item)
    {
        $item = $item instanceof Item ? $item : Item::findOrFail($item);
        $user = Auth::user();

        $statusMenunggu = defined('App\Models\Item::STATUS_MENUNGGU')
            ? Item::STATUS_MENUNGGU
            : 'menunggu';

        // Otorisasi: hanya pemilik dan hanya jika status masih menunggu
        if ($item->user_id !== $user->id || $item->status !== $statusMenunggu) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah laporan ini.');
        }

        $validated = $request->validated();
        $photoPath = $item->photo;

        // Tangani penggantian foto
        if ($request->hasFile('photo')) {
            if ($item->photo) {
                if (class_exists(FileUploadService::class)) {
                    FileUploadService::hapus($item->photo);
                } else {
                    Storage::disk('public')->delete($item->photo);
                }
            }

            if (class_exists(FileUploadService::class)) {
                $photoPath = FileUploadService::simpanPublik($request->file('photo'), 'items');
            } else {
                $photoPath = $request->file('photo')->store('items', 'public');
            }
        }

        // Perbarui atribut laporan
        $item->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'location' => $validated['location'],
            'incident_date' => $validated['incident_date'],
            'incident_time' => $validated['incident_time'] ?? null,
        ]);

        // Catat riwayat perubahan
        if (class_exists(StatusHistoryService::class)) {
            StatusHistoryService::catatPerubahan($item, $user, 'Laporan diubah oleh pelapor');
        }

        return redirect()->route('my-reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Batalkan laporan barang milik pengguna (status menunggu atau dipublikasikan).
     */
    public function cancel($item)
    {
        $item = $item instanceof Item ? $item : Item::findOrFail($item);
        $user = Auth::user();

        $statusMenunggu = defined('App\Models\Item::STATUS_MENUNGGU')
            ? Item::STATUS_MENUNGGU
            : 'menunggu';
        $statusDipublikasikan = defined('App\Models\Item::STATUS_DIPUBLIKASIKAN')
            ? Item::STATUS_DIPUBLIKASIKAN
            : 'dipublikasikan';
        $statusDibatalkan = defined('App\Models\Item::STATUS_DIBATALKAN')
            ? Item::STATUS_DIBATALKAN
            : 'dibatalkan';

        // Otorisasi: hanya pemilik dan status harus menunggu atau dipublikasikan
        if ($item->user_id !== $user->id || !in_array($item->status, [$statusMenunggu, $statusDipublikasikan])) {
            abort(403, 'Laporan ini tidak dapat dibatalkan.');
        }

        // Perubahan status WAJIB melalui StatusHistoryService
        if (class_exists(StatusHistoryService::class)) {
            StatusHistoryService::ubah($item, $statusDibatalkan, $user, 'Dibatalkan oleh pelapor');
        } else {
            $item->update(['status' => $statusDibatalkan]);
        }

        return redirect()->route('my-reports.index')->with('success', 'Laporan berhasil dibatalkan.');
    }
}

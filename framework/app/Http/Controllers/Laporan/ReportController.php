<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laporan\StoreReportRequest;
use App\Models\Category;
use App\Models\Item;
use App\Services\FileUploadService;
use App\Services\NotifikasiService;
use App\Services\StatusHistoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Tampilkan formulir pembuatan laporan barang hilang atau temuan.
     */
    public function create()
    {
        $categories = class_exists(Category::class)
            ? Category::orderBy('name')->get()
            : collect();

        return view('reports.create', compact('categories'));
    }

    /**
     * Simpan laporan barang baru ke dalam database.
     */
    public function store(StoreReportRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        // Unggah foto jika ada
        $photoPath = null;
        if ($request->hasFile('photo')) {
            if (class_exists(FileUploadService::class)) {
                $photoPath = FileUploadService::simpanPublik($request->file('photo'), 'items');
            } else {
                $photoPath = $request->file('photo')->store('items', 'public');
            }
        }

        // Tentukan status awal laporan
        $statusAwal = defined('App\Models\Item::STATUS_MENUNGGU')
            ? Item::STATUS_MENUNGGU
            : 'menunggu';

        // Buat data laporan baru
        $item = Item::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'location' => $validated['location'],
            'incident_date' => $validated['incident_date'],
            'incident_time' => $validated['incident_time'] ?? null,
            'status' => $statusAwal,
        ]);

        // Catat status awal ke riwayat perubahan status
        if (class_exists(StatusHistoryService::class)) {
            StatusHistoryService::catatAwal($item, $user);
        }

        // Kirim notifikasi sistem kepada pelapor
        if (class_exists(NotifikasiService::class)) {
            NotifikasiService::kirim(
                $user,
                'Laporan Diterima',
                'Laporan diterima, menunggu verifikasi admin.',
                route('my-reports.index'),
                'info'
            );
        }

        return redirect()->route('thanks')->with('success', 'Laporan berhasil dibuat dan sedang menunggu verifikasi admin.');
    }
}

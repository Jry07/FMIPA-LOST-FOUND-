<?php

namespace App\Http\Controllers\Klaim;

use App\Http\Controllers\Controller;
use App\Http\Requests\Klaim\StoreClaimRequest;
use App\Http\Requests\Klaim\StoreFindingRequest;
use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use App\Services\FileUploadService;
use App\Services\NotifikasiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClaimController extends Controller
{
    /**
     * Tampilkan formulir pengajuan klaim kepemilikan untuk laporan barang ditemukan (Found).
     * Sesuai FR-08 dan NFR-08.
     */
    public function create(Item $item): View|RedirectResponse
    {
        $statusDipublikasikan = defined(Item::class . '::STATUS_DIPUBLIKASIKAN') ? Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan';
        $statusSelesai = defined(Item::class . '::STATUS_SELESAI') ? Item::STATUS_SELESAI : 'selesai';
        $typeFound = defined(Item::class . '::TYPE_FOUND') ? Item::TYPE_FOUND : 'found';
        $statusDiajukan = defined(Claim::class . '::STATUS_DIAJUKAN') ? Claim::STATUS_DIAJUKAN : 'diajukan';

        // 1. Validasi tipe dan status laporan barang
        if ($item->type !== $typeFound) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Pengajuan klaim hanya dapat dilakukan pada laporan barang ditemukan (Found).');
        }

        if ($item->status === $statusSelesai) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Laporan ini telah selesai diserahterimakan dan tidak dapat diklaim kembali.');
        }

        if ($item->status !== $statusDipublikasikan) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Pengajuan klaim hanya dapat dilakukan pada laporan yang berstatus dipublikasikan.');
        }

        // 2. Pembuat laporan Found tidak boleh mengklaim laporannya sendiri
        if (auth()->check() && (int) $item->user_id === (int) auth()->id()) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda tidak dapat mengajukan klaim pada laporan barang ditemukan yang Anda laporkan sendiri.');
        }

        // 3. Cegah pengajuan ganda (satu user tidak boleh memiliki 2 pengajuan 'diajukan' pada barang yang sama)
        $existingClaim = Claim::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->where('status', $statusDiajukan)
            ->first();

        if ($existingClaim) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda sudah memiliki pengajuan yang sedang diproses untuk barang ini. Silakan pantau perkembangannya di menu Klaim Saya.');
        }

        // Eager load category dan user jika belum
        $item->loadMissing(['category', 'user']);

        return view('claims.create', compact('item'));
    }

    /**
     * Simpan pengajuan klaim kepemilikan barang (FR-08).
     */
    public function store(StoreClaimRequest $request, Item $item): RedirectResponse
    {
        $statusDipublikasikan = defined(Item::class . '::STATUS_DIPUBLIKASIKAN') ? Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan';
        $statusSelesai = defined(Item::class . '::STATUS_SELESAI') ? Item::STATUS_SELESAI : 'selesai';
        $typeFound = defined(Item::class . '::TYPE_FOUND') ? Item::TYPE_FOUND : 'found';
        $statusDiajukan = defined(Claim::class . '::STATUS_DIAJUKAN') ? Claim::STATUS_DIAJUKAN : 'diajukan';
        $typeKlaim = defined(Claim::class . '::TYPE_KLAIM') ? Claim::TYPE_KLAIM : 'klaim';

        // Validasi bisnis kembali sebelum menyimpan
        if ($item->type !== $typeFound || $item->status !== $statusDipublikasikan) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Laporan tidak valid untuk pengajuan klaim.');
        }

        if ((int) $item->user_id === (int) auth()->id()) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda tidak dapat mengajukan klaim pada laporan milik Anda sendiri.');
        }

        $existingClaim = Claim::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->where('status', $statusDiajukan)
            ->first();

        if ($existingClaim) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda sudah memiliki pengajuan klaim yang sedang diproses untuk barang ini.');
        }

        // Simpan bukti klaim secara privat (NFR-05)
        $evidenceFile = $request->file('evidence');
        if (class_exists(FileUploadService::class)) {
            $evidencePath = FileUploadService::simpanPrivat($evidenceFile, 'claims');
        } else {
            // Solusi sementara jika FileUploadService belum ada dari Fase 0
            $evidencePath = $evidenceFile->store('claims', 'local');
        }

        // Simpan data Claim
        $claim = Claim::create([
            'item_id'     => $item->id,
            'user_id'     => auth()->id(),
            'type'        => $typeKlaim,
            'description' => $request->ownership_description,
            'proof'       => $evidencePath,
            'status'      => $statusDiajukan,
        ]);

        // Notifikasi ke semua akun admin dan petugas
        $this->kirimNotifikasiKePengelola(
            'Pengajuan klaim baru',
            'Pengajuan klaim baru untuk ' . ($item->kode ?? ('FND-' . str_pad($item->id, 3, '0', STR_PAD_LEFT))),
            $claim
        );

        return redirect()->route('thanks')
            ->with('success', 'Pengajuan klaim kepemilikan berhasil dikirim.');
    }

    /**
     * Tampilkan formulir pelaporan penemuan barang untuk laporan barang hilang (Lost).
     * Sesuai FR-09.
     */
    public function createFinding(Item $item): View|RedirectResponse
    {
        $statusDipublikasikan = defined(Item::class . '::STATUS_DIPUBLIKASIKAN') ? Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan';
        $statusSelesai = defined(Item::class . '::STATUS_SELESAI') ? Item::STATUS_SELESAI : 'selesai';
        $typeLost = defined(Item::class . '::TYPE_LOST') ? Item::TYPE_LOST : 'lost';
        $statusDiajukan = defined(Claim::class . '::STATUS_DIAJUKAN') ? Claim::STATUS_DIAJUKAN : 'diajukan';

        // 1. Validasi tipe dan status laporan
        if ($item->type !== $typeLost) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Aksi pelaporan penemuan hanya dapat dilakukan pada laporan barang hilang (Lost).');
        }

        if ($item->status === $statusSelesai) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Laporan ini telah selesai diserahterimakan.');
        }

        if ($item->status !== $statusDipublikasikan) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Pelaporan penemuan hanya dapat dilakukan pada laporan yang berstatus dipublikasikan.');
        }

        // 2. DITOLAK jika laporan Lost milik user sendiri (FR-09 aturan wajib SRS)
        if (auth()->check() && (int) $item->user_id === (int) auth()->id()) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda tidak dapat menggunakan aksi ini pada laporan milik Anda sendiri');
        }

        // 3. Cegah pengajuan ganda
        $existingFinding = Claim::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->where('status', $statusDiajukan)
            ->first();

        if ($existingFinding) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda sudah melaporkan penemuan untuk barang ini dan saat ini sedang menunggu verifikasi.');
        }

        $item->loadMissing(['category', 'user']);

        return view('claims.finding-create', compact('item'));
    }

    /**
     * Simpan pelaporan penemuan barang (FR-09).
     */
    public function storeFinding(StoreFindingRequest $request, Item $item): RedirectResponse
    {
        $statusDipublikasikan = defined(Item::class . '::STATUS_DIPUBLIKASIKAN') ? Item::STATUS_DIPUBLIKASIKAN : 'dipublikasikan';
        $typeLost = defined(Item::class . '::TYPE_LOST') ? Item::TYPE_LOST : 'lost';
        $statusDiajukan = defined(Claim::class . '::STATUS_DIAJUKAN') ? Claim::STATUS_DIAJUKAN : 'diajukan';
        $typePenemuan = defined(Claim::class . '::TYPE_PENEMUAN') ? Claim::TYPE_PENEMUAN : 'penemuan';

        if ($item->type !== $typeLost || $item->status !== $statusDipublikasikan) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Laporan tidak valid untuk pelaporan penemuan.');
        }

        // DITOLAK jika laporan Lost milik user sendiri
        if ((int) $item->user_id === (int) auth()->id()) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda tidak dapat menggunakan aksi ini pada laporan milik Anda sendiri');
        }

        $existingFinding = Claim::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->where('status', $statusDiajukan)
            ->first();

        if ($existingFinding) {
            return redirect()->route('items.show', $item)
                ->with('error', 'Anda sudah melaporkan penemuan untuk barang ini yang sedang diproses.');
        }

        // Simpan foto bukti penemuan secara privat
        $evidenceFile = $request->file('evidence');
        if (class_exists(FileUploadService::class)) {
            $evidencePath = FileUploadService::simpanPrivat($evidenceFile, 'claims');
        } else {
            $evidencePath = $evidenceFile->store('claims', 'local');
        }

        // Simpan data Claim (tipe: penemuan)
        $claim = Claim::create([
            'item_id'          => $item->id,
            'user_id'          => auth()->id(),
            'type'             => $typePenemuan,
            'description'      => $request->finding_description,
            'found_location'   => $request->finding_location,
            'found_time'       => $request->finding_time,
            'storage_location' => $request->storage_location,
            'proof'            => $evidencePath,
            'status'           => $statusDiajukan,
        ]);

        // Notifikasi ke semua admin dan petugas
        $this->kirimNotifikasiKePengelola(
            'Laporan penemuan baru',
            'Laporan penemuan baru untuk ' . ($item->kode ?? ('LST-' . str_pad($item->id, 3, '0', STR_PAD_LEFT))),
            $claim
        );

        return redirect()->route('thanks')
            ->with('success', 'Laporan penemuan barang berhasil dikirim.');
    }

    /**
     * Helper kirim notifikasi ke admin dan petugas.
     */
    private function kirimNotifikasiKePengelola(string $judul, string $pesan, Claim $claim): void
    {
        if (! class_exists(NotifikasiService::class)) {
            return;
        }

        $roleAdmin = defined(User::class . '::ROLE_ADMIN') ? User::ROLE_ADMIN : 'admin';
        $rolePetugas = defined(User::class . '::ROLE_PETUGAS') ? User::ROLE_PETUGAS : 'petugas';

        $pengelola = User::whereIn('role', [$roleAdmin, $rolePetugas])->get();

        foreach ($pengelola as $user) {
            NotifikasiService::kirim(
                $user,
                $judul,
                $pesan,
                route('claims.evidence', $claim->id ?? 1),
                'info'
            );
        }
    }
}

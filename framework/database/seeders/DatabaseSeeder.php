<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pengguna, Admin, Petugas
        $admin = User::firstOrCreate(
            ['email' => 'admin@fmipa.test'],
            [
                'name' => 'Administrator FMIPA',
                'nim' => 'ADM001',
                'role' => User::ROLE_ADMIN,
                'password' => Hash::make('password'),
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@fmipa.test'],
            [
                'name' => 'Petugas Keamanan FMIPA',
                'nim' => 'PTG001',
                'role' => User::ROLE_PETUGAS,
                'password' => Hash::make('password'),
            ]
        );

        $pengguna1 = User::firstOrCreate(
            ['email' => 'pengguna1@fmipa.test'],
            [
                'name' => 'Muhammad Aimar Razak',
                'nim' => 'F1G125013',
                'role' => User::ROLE_PENGGUNA,
                'password' => Hash::make('password'),
            ]
        );

        $pengguna2 = User::firstOrCreate(
            ['email' => 'pengguna2@fmipa.test'],
            [
                'name' => 'Budi Santoso',
                'nim' => 'F1G125099',
                'role' => User::ROLE_PENGGUNA,
                'password' => Hash::make('password'),
            ]
        );

        // 2. Kategori Barang
        $katElektronik = Category::firstOrCreate(['name' => 'Elektronik'], ['description' => 'Laptop, HP, Kalkulator, Charger, Flashdisk']);
        $katDokumen = Category::firstOrCreate(['name' => 'Dokumen'], ['description' => 'KTM, KTP, STNK, Buku Catatan']);
        $katAksesoris = Category::firstOrCreate(['name' => 'Aksesoris'], ['description' => 'Kacamata, Jam Tangan, Kunci']);
        $katTas = Category::firstOrCreate(['name' => 'Tas & Dompet'], ['description' => 'Tas Ransel, Dompet, Tote Bag']);

        // 3. Item Menunggu Verifikasi (FR-07)
        $itemMenunggu1 = Item::firstOrCreate(
            ['name' => 'Tumbler Hijau Sage'],
            [
                'user_id' => $pengguna1->id,
                'category_id' => $katAksesoris->id,
                'type' => Item::TYPE_LOST,
                'description' => 'Tumbler warna hijau sage merek Corkcicle ukuran 500ml, terdapat stiker UHO di sampingnya.',
                'location' => 'Taman FMIPA UHO',
                'incident_date' => now()->subDays(2),
                'incident_time' => '10:30:00',
                'status' => Item::STATUS_MENUNGGU,
            ]
        );

        $itemMenunggu2 = Item::firstOrCreate(
            ['name' => 'Kartu Mahasiswa (KTM)'],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $katDokumen->id,
                'type' => Item::TYPE_FOUND,
                'description' => 'Ditemukan KTM atas nama mahasiswa Jurusan Matematika angkatan 2024 di meja Lab Komputer.',
                'location' => 'Laboratorium Komputer Lantai 2 FMIPA',
                'incident_date' => now()->subDay(),
                'incident_time' => '14:15:00',
                'status' => Item::STATUS_MENUNGGU,
            ]
        );

        // 4. Item Dipublikasikan untuk Uji Klaim & Penemuan (FR-10)
        // Kasus A: Laporan Found -> Pengguna 2 mengajukan Klaim kepemilikan
        $itemFound = Item::firstOrCreate(
            ['name' => 'Kalkulator Ilmiah Casio FX-991EX'],
            [
                'user_id' => $pengguna1->id,
                'category_id' => $katElektronik->id,
                'type' => Item::TYPE_FOUND,
                'description' => 'Ditemukan kalkulator ilmiah warna hitam di Ruang Kuliah 3 Gedung FMIPA.',
                'location' => 'Ruang Kuliah 3 FMIPA',
                'incident_date' => now()->subDays(4),
                'incident_time' => '11:00:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ]
        );

        $claimKlaim = Claim::firstOrCreate(
            ['item_id' => $itemFound->id, 'submitter_id' => $pengguna2->id],
            [
                'type' => Claim::TYPE_KLAIM,
                'ownership_description' => 'Kalkulator tersebut milik saya, di bagian belakang terdapat bekas goresan kecil dan stiker nama Budi.',
                'evidence' => 'evidence/sample_kalkulator.jpg',
                'status' => Claim::STATUS_DIAJUKAN,
            ]
        );

        // Kasus B: Laporan Lost -> Pengguna 1 menemukan barang dan membuat pengajuan Penemuan
        $itemLost = Item::firstOrCreate(
            ['name' => 'Kunci Motor Honda Vario'],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $katAksesoris->id,
                'type' => Item::TYPE_LOST,
                'description' => 'Kunci motor dengan gantungan kain bertuliskan FMIPA, hilang di sekitar area parkir barat.',
                'location' => 'Parkiran Barat FMIPA',
                'incident_date' => now()->subDays(3),
                'incident_time' => '08:45:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ]
        );

        $claimPenemuan = Claim::firstOrCreate(
            ['item_id' => $itemLost->id, 'submitter_id' => $pengguna1->id],
            [
                'type' => Claim::TYPE_PENEMUAN,
                'finding_description' => 'Saya menemukan kunci ini tergeletak di dekat pos satpam parkiran motor.',
                'finding_location' => 'Dekat pos satpam parkiran motor',
                'finding_time' => now()->subDays(2),
                'storage_location' => 'Pos Satpam FMIPA',
                'evidence' => 'evidence/sample_kunci.jpg',
                'status' => Claim::STATUS_DIAJUKAN,
            ]
        );

        // 5. Item & Claim Diterima untuk Uji Serah Terima (FR-11)
        $itemReadyForHandover = Item::firstOrCreate(
            ['name' => 'Dompet Kulit Cokelat'],
            [
                'user_id' => $pengguna1->id, // penemu membuat laporan Found
                'category_id' => $katTas->id,
                'type' => Item::TYPE_FOUND,
                'description' => 'Dompet kulit warna cokelat merk Baellerry ditemukan di musholla FMIPA.',
                'location' => 'Musholla FMIPA',
                'incident_date' => now()->subDays(5),
                'incident_time' => '13:00:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ]
        );

        $claimAccepted = Claim::firstOrCreate(
            ['item_id' => $itemReadyForHandover->id, 'submitter_id' => $pengguna2->id],
            [
                'type' => Claim::TYPE_KLAIM,
                'ownership_description' => 'Dompet cokelat saya tertinggal saat sholat dzuhur, di dalamnya ada KTM dan uang saku.',
                'evidence' => 'evidence/sample_dompet.jpg',
                'status' => Claim::STATUS_DITERIMA,
                'verifier_id' => $admin->id,
                'verified_at' => now()->subDay(),
            ]
        );
    }
}

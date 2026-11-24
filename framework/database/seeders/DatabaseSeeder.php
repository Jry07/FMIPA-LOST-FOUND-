<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Claim;
use App\Models\HandoverRecord;
use App\Models\Item;
use App\Models\ItemStatusHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna, Petugas, dan Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@fmipa.test'],
            [
                'name' => 'Administrator FMIPA',
                'nim' => null,
                'role' => User::ROLE_ADMIN,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@fmipa.test'],
            [
                'name' => 'Petugas Keamanan FMIPA',
                'nim' => null,
                'role' => User::ROLE_PETUGAS,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $pengguna1 = User::firstOrCreate(
            ['email' => 'pengguna1@fmipa.test'],
            [
                'name' => 'Muhammad Fajri Jumadil',
                'nim' => 'F1G125041',
                'role' => User::ROLE_PENGGUNA,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $pengguna2 = User::firstOrCreate(
            ['email' => 'pengguna2@fmipa.test'],
            [
                'name' => 'Ferdy Krisnandar',
                'nim' => 'F1G125032',
                'role' => User::ROLE_PENGGUNA,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $pengguna3 = User::firstOrCreate(
            ['email' => 'pengguna3@fmipa.test'],
            [
                'name' => 'Rahmah Hidayah Lahompu',
                'nim' => 'F1G125047',
                'role' => User::ROLE_PENGGUNA,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. 7 Kategori Baku Sesuai Kontrak
        $kategoriData = [
            ['name' => 'Elektronik', 'description' => 'Laptop, handphone, tablet, charger, flashdisk, kalkulator, dsb.'],
            ['name' => 'Tas dan Dompet', 'description' => 'Tas ransel, totebag, dompet kartu, pouch, dsb.'],
            ['name' => 'Dokumen dan Kartu', 'description' => 'KTM, KTP, SIM, STNK, berkas ujian, ijazah, dsb.'],
            ['name' => 'Kunci', 'description' => 'Kunci motor, kunci mobil, kunci loker/kamar kos, dsb.'],
            ['name' => 'Pakaian', 'description' => 'Jaket almamater, rompi, helm, topi, syal, dsb.'],
            ['name' => 'Alat Tulis', 'description' => 'Tempat pensil, binder, buku catatan, kalkulator standar, dsb.'],
            ['name' => 'Lainnya', 'description' => 'Tumbler, payung, kacamata, botol minum, aksesoris lainnya.'],
        ];

        $kategoriMap = [];
        foreach ($kategoriData as $k) {
            $kategoriMap[$k['name']] = Category::firstOrCreate(['name' => $k['name']], $k);
        }

        $photoPlaceholder = 'items/placeholder.svg';

        // 3. Sekitar 12 Laporan Barang Lost & Found
        $itemsData = [
            [
                'user_id' => $pengguna1->id,
                'category_id' => $kategoriMap['Lainnya']->id,
                'name' => 'Tumbler Hijau Sage',
                'type' => Item::TYPE_FOUND,
                'description' => 'Tumbler Corkcicle warna hijau sage ukuran 500ml, terdapat sedikit goresan di bagian bawah botol.',
                'photo' => $photoPlaceholder,
                'location' => 'Gedung Perkuliahan FMIPA Lt. 2 R.204',
                'incident_date' => Carbon::today()->subDays(2),
                'incident_time' => '10:15:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $kategoriMap['Elektronik']->id,
                'name' => 'Laptop Hitam Lenovo ThinkPad',
                'type' => Item::TYPE_LOST,
                'description' => 'Laptop ThinkPad warna hitam dengan stiker GitHub dan UHO di cover belakang. Tertinggal di meja depan lab.',
                'photo' => $photoPlaceholder,
                'location' => 'Laboratorium Komputasi FMIPA Lantai 1',
                'incident_date' => Carbon::today()->subDays(3),
                'incident_time' => '15:30:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna3->id,
                'category_id' => $kategoriMap['Dokumen dan Kartu']->id,
                'name' => 'Kartu Mahasiswa (KTM) UHO',
                'type' => Item::TYPE_FOUND,
                'description' => 'KTM atas nama mahasiswa Jurusan Matematika FMIPA UHO, ditemukan di dekat area kantin.',
                'photo' => $photoPlaceholder,
                'location' => 'Kantin Fakultas MIPA',
                'incident_date' => Carbon::today()->subDays(1),
                'incident_time' => '12:00:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna1->id,
                'category_id' => $kategoriMap['Kunci']->id,
                'name' => 'Kunci Motor Honda Beat',
                'type' => Item::TYPE_FOUND,
                'description' => 'Kunci motor Honda dengan gantungan pita merah bertuliskan UHO.',
                'photo' => $photoPlaceholder,
                'location' => 'Parkiran Sepeda Motor Gedung C FMIPA',
                'incident_date' => Carbon::today()->subDays(5),
                'incident_time' => '08:45:00',
                'status' => Item::STATUS_SELESAI,
            ],
            [
                'user_id' => $pengguna3->id,
                'category_id' => $kategoriMap['Elektronik']->id,
                'name' => 'Kalkulator Ilmiah Hitam Casio fx-991EX',
                'type' => Item::TYPE_LOST,
                'description' => 'Kalkulator scientific warna hitam dengan tulisan nama di bagian belakang cover pelindung.',
                'photo' => $photoPlaceholder,
                'location' => 'Ruang Ujian Gedung B FMIPA R.B102',
                'incident_date' => Carbon::today()->subDays(4),
                'incident_time' => '11:00:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $kategoriMap['Tas dan Dompet']->id,
                'name' => 'Dompet Kulit Hitam Eiger',
                'type' => Item::TYPE_LOST,
                'description' => 'Dompet kulit lipat dua warna hitam, berisi kartu identitas dan sejumlah uang tunai.',
                'photo' => $photoPlaceholder,
                'location' => 'Musholla FMIPA UHO',
                'incident_date' => Carbon::today()->subDays(6),
                'incident_time' => '13:10:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna1->id,
                'category_id' => $kategoriMap['Pakaian']->id,
                'name' => 'Jaket Almamater FMIPA UHO',
                'type' => Item::TYPE_FOUND,
                'description' => 'Jaket almamater warna kuning kunyit ukuran L, bordir FMIPA di bagian dada kiri.',
                'photo' => $photoPlaceholder,
                'location' => 'Bale Bengong Gazebo FMIPA',
                'incident_date' => Carbon::today()->subDays(2),
                'incident_time' => '16:40:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna3->id,
                'category_id' => $kategoriMap['Alat Tulis']->id,
                'name' => 'Buku Catatan Statistika Matematika',
                'type' => Item::TYPE_FOUND,
                'description' => 'Buku binder bergaris warna cokelat pastel dengan stiker rumus statistika di halaman pertama.',
                'photo' => $photoPlaceholder,
                'location' => 'Perpustakaan FMIPA Lt. 2',
                'incident_date' => Carbon::today()->subDays(1),
                'incident_time' => '14:20:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $kategoriMap['Elektronik']->id,
                'name' => 'Flashdisk Sandisk 32GB Merah Hitam',
                'type' => Item::TYPE_LOST,
                'description' => 'Flashdisk SanDisk Cruzer Blade 32GB berisi materi tugas akhir dan praktikum.',
                'photo' => $photoPlaceholder,
                'location' => 'Laboratorium Multimedia FMIPA',
                'incident_date' => Carbon::today(),
                'incident_time' => '09:10:00',
                'status' => Item::STATUS_MENUNGGU,
            ],
            [
                'user_id' => $pengguna1->id,
                'category_id' => $kategoriMap['Lainnya']->id,
                'name' => 'Kacamata Minus Frame Hitam Titanium',
                'type' => Item::TYPE_FOUND,
                'description' => 'Kacamata frame bulat warna hitam dengan kotak kacamata warna abu-abu bertuliskan Optik Seis.',
                'photo' => $photoPlaceholder,
                'location' => 'Toilet Lantai 1 Gedung Dekanat FMIPA',
                'incident_date' => Carbon::today()->subDays(3),
                'incident_time' => '15:00:00',
                'status' => Item::STATUS_DIPUBLIKASIKAN,
            ],
            [
                'user_id' => $pengguna3->id,
                'category_id' => $kategoriMap['Elektronik']->id,
                'name' => 'Jam Tangan Casio Standar Digital',
                'type' => Item::TYPE_LOST,
                'description' => 'Laporan uji coba dengan data tidak lengkap atau bercanda.',
                'photo' => null,
                'location' => 'Sekitar Lapangan Kampus',
                'incident_date' => Carbon::today()->subDays(10),
                'incident_time' => null,
                'status' => Item::STATUS_DITOLAK,
            ],
            [
                'user_id' => $pengguna2->id,
                'category_id' => $kategoriMap['Elektronik']->id,
                'name' => 'Headphone Bluetooth Hitam Sony',
                'type' => Item::TYPE_LOST,
                'description' => 'Barang sudah ditemukan sendiri oleh pelapor di dalam tas pribadi.',
                'photo' => $photoPlaceholder,
                'location' => 'Ruang Baca Mahasiswa FMIPA',
                'incident_date' => Carbon::today()->subDays(7),
                'incident_time' => '11:30:00',
                'status' => Item::STATUS_DIBATALKAN,
            ],
        ];

        $items = [];
        foreach ($itemsData as $data) {
            $item = Item::create($data);
            $items[$item->name] = $item;

            // Catat riwayat awal
            ItemStatusHistory::create([
                'item_id' => $item->id,
                'user_id' => $item->user_id,
                'previous_status' => null,
                'new_status' => Item::STATUS_MENUNGGU,
                'notes' => 'Laporan dibuat oleh pengguna.',
                'created_at' => $item->created_at,
            ]);

            // Jika statusnya bukan menunggu, catat riwayat verifikasinya
            if ($item->status !== Item::STATUS_MENUNGGU) {
                ItemStatusHistory::create([
                    'item_id' => $item->id,
                    'user_id' => $admin->id,
                    'previous_status' => Item::STATUS_MENUNGGU,
                    'new_status' => $item->status,
                    'notes' => match ($item->status) {
                        Item::STATUS_DIPUBLIKASIKAN => 'Laporan diverifikasi dan disetujui oleh admin.',
                        Item::STATUS_DITOLAK => 'Laporan ditolak karena informasi kurang memadai.',
                        Item::STATUS_DIBATALKAN => 'Laporan dibatalkan oleh pemilik laporan.',
                        Item::STATUS_SELESAI => 'Laporan dipublikasikan dan telah selesai diproses.',
                        default => 'Status diperbarui.',
                    },
                    'created_at' => $item->created_at->addMinutes(30),
                ]);
            }
        }

        // 4. Seeder Claims (Klaim & Penemuan)
        // 4.1 Klaim Diajukan pada Tumbler Hijau Sage
        Claim::create([
            'item_id' => $items['Tumbler Hijau Sage']->id,
            'user_id' => $pengguna2->id,
            'type' => Claim::TYPE_KLAIM,
            'description' => 'Saya adalah pemilik tumbler tersebut. Di bagian bawah terdapat inisial nama "FK" tergores halus.',
            'proof' => 'evidences/bukti-placeholder.txt',
            'status' => Claim::STATUS_DIAJUKAN,
            'verifier_id' => null,
            'verified_at' => null,
        ]);

        // 4.2 Pelaporan Penemuan (Aksi "Saya Menemukan Barang Ini") pada Kalkulator Ilmiah Hitam
        Claim::create([
            'item_id' => $items['Kalkulator Ilmiah Hitam Casio fx-991EX']->id,
            'user_id' => $pengguna1->id,
            'type' => Claim::TYPE_PENEMUAN,
            'description' => 'Saya menemukan kalkulator ini tertinggal di laci meja baris ketiga Ruang B102.',
            'proof' => 'evidences/bukti-placeholder.txt',
            'found_location' => 'Laci Meja R.B102 Gedung B FMIPA',
            'found_time' => Carbon::today()->subDays(3)->setHour(14)->setMinute(0),
            'storage_location' => 'Pos Satpam FMIPA (dititipkan ke Petugas)',
            'status' => Claim::STATUS_DIAJUKAN,
            'verifier_id' => null,
            'verified_at' => null,
        ]);

        // 4.3 Klaim Ditolak pada Jaket Almamater
        Claim::create([
            'item_id' => $items['Jaket Almamater FMIPA UHO']->id,
            'user_id' => $pengguna3->id,
            'type' => Claim::TYPE_KLAIM,
            'description' => 'Saya merasa jaket ini milik saya yang tertinggal minggu lalu.',
            'proof' => null,
            'status' => Claim::STATUS_DITOLAK,
            'verifier_id' => $admin->id,
            'verified_at' => now()->subDay(),
            'rejection_reason' => 'Ukuran jaket yang dicari adalah M, sedangkan barang temuan berukuran L.',
        ]);

        // 4.4 Klaim Diterima & Handover Selesai pada Kunci Motor Honda Beat
        $claimSelesai = Claim::create([
            'item_id' => $items['Kunci Motor Honda Beat']->id,
            'user_id' => $pengguna2->id,
            'type' => Claim::TYPE_KLAIM,
            'description' => 'Kunci motor beat saya hilang kemarin, ada gantungan pita merah UHO dan anak kunci cadangan kecil.',
            'proof' => 'evidences/bukti-placeholder.txt',
            'status' => Claim::STATUS_DITERIMA,
            'verifier_id' => $petugas->id,
            'verified_at' => now()->subHours(5),
        ]);

        // 5. 1 Handover Selesai
        HandoverRecord::create([
            'item_id' => $items['Kunci Motor Honda Beat']->id,
            'claim_id' => $claimSelesai->id,
            'officer_id' => $petugas->id,
            'receiver_id' => $pengguna2->id,
            'notes' => 'Pencocokan STNK dan identitas KTM berhasil. Barang fisik diserahkan langsung di Pos Keamanan FMIPA.',
            'handover_date' => now()->subHours(4),
        ]);

        // Catat riwayat status selesai pada Kunci Motor Honda Beat
        ItemStatusHistory::create([
            'item_id' => $items['Kunci Motor Honda Beat']->id,
            'user_id' => $petugas->id,
            'previous_status' => Item::STATUS_DIPUBLIKASIKAN,
            'new_status' => Item::STATUS_SELESAI,
            'notes' => 'Barang telah diserahterimakan kepada pemilik sah (' . $pengguna2->name . ').',
            'created_at' => now()->subHours(4),
        ]);
    }
}

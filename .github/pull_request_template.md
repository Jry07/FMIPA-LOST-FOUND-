## Deskripsi Perubahan

<!-- Jelaskan singkat apa yang diubah dan mengapa -->

---

## Modul yang Dikerjakan

- [ ] M1 - Admin Panel
- [ ] M2 - Autentikasi
- [ ] M3 - Laporan Barang
- [ ] M4 - Katalog Barang
- [ ] M5 - Klaim
- [ ] M6 - Verifikasi

---

## Checklist Wajib

- [ ] File yang diubah **hanya milik modul saya** (tidak menyentuh file modul lain)
- [ ] **Nama route tidak berubah** dari yang ada di `routes/web.php` dan `docs/KONTRAK.md`
- [ ] Setiap perubahan status item/klaim dilakukan **lewat `StatusHistoryService`** (bukan langsung `$model->status = ...`)
- [ ] Notifikasi dikirim lewat **`NotifikasiService`** (bukan `$user->notify()` langsung)
- [ ] Upload file dilakukan lewat **`FileUploadService`**
- [ ] Kode dibungkus **marker blok** `// [MX-NAMA]` / `{{-- [MX-NAMA] --}}` yang sesuai
- [ ] Sudah **uji manual** di browser (login sebagai role yang relevan)
- [ ] **Migrasi** (jika ada): dapat dijalankan ulang dengan `migrate:fresh --seed` tanpa error
- [ ] **Tidak ada** kredensial nyata, API key, atau data sensitif di kode

---

## Tangkapan Layar / Bukti

<!-- Lampirkan screenshot halaman yang berubah, terutama untuk perubahan tampilan -->

| Sebelum | Sesudah |
|---------|---------|
| —       | —       |

---

## Catatan untuk Reviewer

<!-- Hal-hal yang perlu diperhatikan reviewer, keputusan desain, atau ketergantungan dengan modul lain -->

---

## Related Issue / Trello Card

<!-- Link ke card Trello atau issue yang dikerjakan -->
- Closes #

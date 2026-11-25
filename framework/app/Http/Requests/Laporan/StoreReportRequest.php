<?php

namespace App\Http\Requests\Laporan;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'in:lost,found'],
            'name' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['required', 'string', 'min:10'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'location' => ['required', 'string', 'max:150'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'incident_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    /**
     * Nama atribut khusus untuk pesan validasi (Bahasa Indonesia).
     */
    public function attributes(): array
    {
        return [
            'type' => 'jenis laporan',
            'name' => 'nama barang',
            'category_id' => 'kategori barang',
            'description' => 'deskripsi barang',
            'photo' => 'foto barang',
            'location' => 'lokasi kejadian',
            'incident_date' => 'tanggal kejadian',
            'incident_time' => 'jam kejadian',
        ];
    }

    /**
     * Pesan kesalahan khusus untuk aturan yang divalidasi.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Jenis laporan (Hilang atau Ditemukan) wajib dipilih.',
            'type.in' => 'Jenis laporan yang dipilih tidak valid.',
            'name.required' => 'Nama barang wajib diisi.',
            'name.max' => 'Nama barang maksimal 100 karakter.',
            'category_id.required' => 'Kategori barang wajib dipilih.',
            'category_id.exists' => 'Kategori barang yang dipilih tidak ditemukan.',
            'description.required' => 'Deskripsi dan ciri barang wajib diisi.',
            'description.min' => 'Deskripsi barang minimal 10 karakter.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.mimes' => 'Format foto harus berupa JPG, JPEG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
            'location.required' => 'Lokasi kejadian wajib diisi.',
            'location.max' => 'Lokasi kejadian maksimal 150 karakter.',
            'incident_date.required' => 'Tanggal kejadian wajib diisi.',
            'incident_date.before_or_equal' => 'Tanggal kejadian tidak boleh melewati hari ini.',
            'incident_time.date_format' => 'Format jam kejadian harus HH:MM (contoh: 14:30).',
        ];
    }
}

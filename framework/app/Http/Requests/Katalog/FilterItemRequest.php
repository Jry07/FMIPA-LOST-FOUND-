<?php

namespace App\Http\Requests\Katalog;

use Illuminate\Foundation\Http\FormRequest;

class FilterItemRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna berwenang membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk filter katalog barang (FR-05).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'q'              => ['nullable', 'string', 'max:100'],
            'category_id'    => ['nullable', 'integer'],
            'location'       => ['nullable', 'string', 'max:100'],
            'type'           => ['nullable', 'string', 'in:all,lost,found'],
            'status'         => ['nullable', 'string', 'in:dipublikasikan,selesai'],
            'tanggal_dari'   => ['nullable', 'date'],
            'tanggal_sampai' => ['nullable', 'date', 'after_or_equal:tanggal_dari'],
            'tanggal'        => ['nullable', 'date'],
        ];
    }

    /**
     * Pesan kesalahan validasi dalam Bahasa Indonesia (NFR-06, NFR-07).
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'q.max'                         => 'Kata kunci pencarian maksimal 100 karakter.',
            'category_id.integer'           => 'Kategori yang dipilih tidak valid.',
            'location.max'                  => 'Lokasi pencarian maksimal 100 karakter.',
            'type.in'                       => 'Pilihan jenis barang harus berupa semua, hilang, atau ditemukan.',
            'status.in'                     => 'Status laporan harus berupa dipublikasikan atau selesai.',
            'tanggal_dari.date'             => 'Format tanggal awal tidak valid.',
            'tanggal_sampai.date'           => 'Format tanggal akhir tidak valid.',
            'tanggal_sampai.after_or_equal' => 'Tanggal akhir harus sama dengan atau setelah tanggal awal.',
            'tanggal.date'                  => 'Format tanggal tidak valid.',
        ];
    }
}

<?php

namespace App\Http\Requests\Klaim;

use Illuminate\Foundation\Http\FormRequest;

class StoreFindingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'finding_description' => ['required', 'string', 'min:20'],
            'finding_location'    => ['required', 'string', 'max:255'],
            'finding_time'        => ['required', 'date', 'before_or_equal:now'],
            'storage_location'    => ['required', 'string', 'max:255'],
            'evidence'            => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'finding_description' => 'deskripsi penemuan',
            'finding_location'    => 'lokasi ditemukan',
            'finding_time'        => 'waktu ditemukan',
            'storage_location'    => 'lokasi penyimpanan / penitipan',
            'evidence'            => 'foto / bukti penemuan',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'finding_description.required' => 'Deskripsi penemuan dan kondisi barang wajib diisi.',
            'finding_description.min'      => 'Deskripsi penemuan minimal 20 karakter untuk mempermudah pencocokan fisik barang.',
            'finding_location.required'    => 'Lokasi barang ditemukan wajib diisi.',
            'finding_location.max'         => 'Lokasi ditemukan maksimal 255 karakter.',
            'finding_time.required'        => 'Waktu barang ditemukan wajib diisi.',
            'finding_time.date'            => 'Format waktu ditemukan tidak valid.',
            'finding_time.before_or_equal' => 'Waktu ditemukan tidak boleh berada di masa depan.',
            'storage_location.required'    => 'Lokasi penyimpanan atau penitipan barang wajib diisi (misalnya: Pos Satpam Kampus Baru).',
            'storage_location.max'         => 'Lokasi penyimpanan maksimal 255 karakter.',
            'evidence.required'            => 'Foto atau bukti penemuan barang wajib diunggah.',
            'evidence.file'                => 'Foto bukti penemuan harus berupa berkas yang valid.',
            'evidence.image'               => 'Foto bukti penemuan harus berupa berkas gambar.',
            'evidence.mimes'               => 'Format foto bukti harus JPG, JPEG, PNG, atau WEBP.',
            'evidence.max'                 => 'Ukuran foto bukti maksimal 2 MB.',
        ];
    }
}

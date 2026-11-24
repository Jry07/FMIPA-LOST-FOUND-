<?php

namespace App\Http\Requests\Klaim;

use Illuminate\Foundation\Http\FormRequest;

class StoreClaimRequest extends FormRequest
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
            'ownership_description' => ['required', 'string', 'min:20'],
            'evidence'              => ['required', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
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
            'ownership_description' => 'deskripsi kepemilikan',
            'evidence'              => 'bukti kepemilikan',
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
            'ownership_description.required' => 'Deskripsi kepemilikan wajib diisi.',
            'ownership_description.min'      => 'Deskripsi kepemilikan minimal 20 karakter agar ciri khusus barang dapat diverifikasi dengan jelas.',
            'evidence.required'              => 'Bukti kepemilikan wajib diunggah.',
            'evidence.file'                  => 'Bukti kepemilikan harus berupa berkas yang valid.',
            'evidence.image'                 => 'Bukti kepemilikan harus berupa gambar (foto).',
            'evidence.mimes'                 => 'Format bukti kepemilikan harus JPG, JPEG, PNG, atau WEBP.',
            'evidence.max'                   => 'Ukuran bukti kepemilikan maksimal 2 MB.',
        ];
    }
}

<?php

namespace App\Http\Requests\Verifikasi;

use Illuminate\Foundation\Http\FormRequest;

class StoreHandoverRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya petugas yang diizinkan (selain middleware, cek kepemilikan/role di controller & request)
        return auth()->check() && auth()->user()->isPetugas();
    }

    public function rules(): array
    {
        return [
            'identity_confirmed' => ['accepted'],
            'return_note' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'identity_confirmed.accepted' => 'Anda wajib mencentang konfirmasi kesesuaian identitas dan bukti fisik.',
            'return_note.required' => 'Catatan pengembalian wajib diisi.',
            'return_note.string' => 'Catatan pengembalian harus berupa teks.',
            'return_note.max' => 'Catatan pengembalian tidak boleh lebih dari 500 karakter.',
        ];
    }
}

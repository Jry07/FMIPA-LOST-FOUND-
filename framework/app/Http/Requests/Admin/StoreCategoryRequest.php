<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

// [M1-ADMIN]
class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:60', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max'      => 'Nama kategori maksimal 60 karakter.',
            'name.unique'   => 'Nama kategori sudah digunakan, silakan gunakan nama lain.',
            'description.max' => 'Deskripsi maksimal 255 karakter.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nama kategori',
            'description' => 'deskripsi',
        ];
    }
}
// [/M1-ADMIN]

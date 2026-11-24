<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// [M1-ADMIN]
class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? $this->route('category');

        return [
            'name'        => [
                'required',
                'string',
                'max:60',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
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

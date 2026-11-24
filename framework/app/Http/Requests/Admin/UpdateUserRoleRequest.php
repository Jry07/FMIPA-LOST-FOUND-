<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// [M1-ADMIN]
class UpdateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Admin tidak boleh mengubah role dirinya sendiri
        $targetUser = $this->route('user');
        if ($targetUser && $targetUser->id === $this->user()->id) {
            return false;
        }

        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'role' => [
                'required',
                Rule::in([
                    User::ROLE_PENGGUNA,
                    User::ROLE_ADMIN,
                    User::ROLE_PETUGAS,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'role.required' => 'Peran akun wajib dipilih.',
            'role.in'       => 'Peran yang dipilih tidak valid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'role' => 'peran akun',
        ];
    }

    protected function failedAuthorization()
    {
        // Pesan khusus jika admin mencoba ubah role dirinya sendiri
        $targetUser = $this->route('user');
        if ($targetUser && $targetUser->id === $this->user()->id) {
            abort(403, 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        parent::failedAuthorization();
    }
}
// [/M1-ADMIN]

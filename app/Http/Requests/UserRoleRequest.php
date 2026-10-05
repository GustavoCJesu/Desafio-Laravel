<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_role_id' => 'required|exists:user_roles,id',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'user_role_id.required' => 'A função é obrigatória.',
            'user_role_id.exists' => 'Função inválida.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class UserRequest extends FormRequest
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
            'employee_id' => 'required|exists:employees,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'user_role_id' => 'required|exists:user_roles,id',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'employee_id.required' => 'O funcionário é obrigatório.',
            'employee_id.exists' => 'Funcionário inválido.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Email inválido.',
            'email.unique' => 'Email já cadastrado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'user_role_id.required' => 'A função é obrigatória.',
            'user_role_id.exists' => 'Função inválida.',
        ];
    }
}

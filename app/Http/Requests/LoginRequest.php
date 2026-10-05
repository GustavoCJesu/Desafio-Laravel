<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:30',
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'email.email' => 'O campo deve ser preenchido com um e-mail válido.',
            'password.required' => 'O campo de senha deve ser preenchido.',
            'password.min' => 'A senha deve conter no mínimo 6 caracteres.',
            'password.max' => 'A senha deve conter no máximo 30 caracteres.',
        ];
    }
}

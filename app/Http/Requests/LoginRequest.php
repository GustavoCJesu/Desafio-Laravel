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
            'email' =>'required|email',
            'password' => 'required|min:6|max:30'
        ];
    }

    #[Override]
    public function messages()
    {
        return [
            'email.required' => 'O campo email é obrigatorio.',
            'email.unique' => 'Este email ja esta em uso.',
            'email.email' => 'O campo deve ser preenchido com um email valido.',
            'password.required' => 'O campo de senha deve ser preenciho.',
            'password.min' => 'A senha deve conter no minimo 6 caracteres.',
            'password.max' => 'A senha deve conter no maximo 30 caracteres.'
        ];
    }
}

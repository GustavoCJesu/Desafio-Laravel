<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class EpiRequest extends FormRequest
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
            'ca' => ['required', 'string', 'max:10'],
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'ca.required' => 'O CA é obrigatório.',
            'ca.max' => 'O CA deve ter no máximo 10 caracteres.',
        ];
    }
}

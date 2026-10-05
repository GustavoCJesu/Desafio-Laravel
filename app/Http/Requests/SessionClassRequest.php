<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class SessionClassRequest extends FormRequest
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
            'class_dt' => 'required|date',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'class_dt.required' => 'A data e hora da aula são obrigatórias.',
            'class_dt.date' => 'Data e hora da aula inválidas.',
        ];
    }
}

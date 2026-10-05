<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class PositionRequest extends FormRequest
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
            'title' => 'required|string|max:255',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'title.required' => 'O nome do cargo é obrigatório.',
            'title.max' => 'O nome do cargo deve ter no máximo 255 caracteres.',
        ];
    }
}

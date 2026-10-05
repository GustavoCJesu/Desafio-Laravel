<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class AttendanceRequest extends FormRequest
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
            'class_id' => 'required|exists:classes,id',
            'employees' => 'nullable|array',
            'employees.*' => 'exists:employees,id',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'class_id.required' => 'Selecione a aula.',
            'class_id.exists' => 'Aula inválida.',
            'employees.*.exists' => 'Funcionário inválido.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class ComplianceReportRequest extends FormRequest
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
            'sector_id' => 'nullable|integer|exists:sectors,id',
            'norm' => 'nullable|string|max:10',
            'only_pending' => 'nullable|boolean',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'sector_id.exists' => 'Setor inválido.',
            'norm.max' => 'A norma deve ter no máximo 10 caracteres.',
            'only_pending.boolean' => 'Opção de pendências inválida.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class SessionTrainingRequest extends FormRequest
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
            'norm' => 'required|string|max:10',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'instructor_id' => 'required|exists:employees,id',
            'status' => ['required', Rule::in(['Agendado', 'Concluído', 'Cancelado'])],
            'validity_dt' => 'required|date',
            'class_min' => 'required|integer|min:1',
            'min_hours' => 'required|integer|min:1|lte:class_min',
            'class_amount' => 'required|integer|min:1',
            'capacity' => 'required|integer|min:1',
            'location' => 'nullable|string|max:255',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'norm.required' => 'A norma é obrigatória.',
            'norm.max' => 'A norma deve ter no máximo 10 caracteres.',
            'title.required' => 'O título é obrigatório.',
            'description.required' => 'A descrição é obrigatória.',
            'instructor_id.required' => 'O instrutor é obrigatório.',
            'instructor_id.exists' => 'Instrutor inválido.',
            'status.in' => 'Status inválido.',
            'validity_dt.required' => 'A validade do certificado é obrigatória.',
            'validity_dt.date' => 'Validade do certificado inválida.',
            'class_min.required' => 'A carga horária é obrigatória.',
            'class_min.min' => 'A carga horária deve ser de pelo menos 1 hora.',
            'min_hours.required' => 'A carga horária mínima é obrigatória.',
            'min_hours.lte' => 'A carga horária mínima não pode ser maior que a carga horária.',
            'class_amount.required' => 'A quantidade de aulas é obrigatória.',
            'class_amount.min' => 'A quantidade de aulas deve ser de pelo menos 1.',
            'capacity.required' => 'A quantidade de vagas é obrigatória.',
            'capacity.min' => 'A quantidade de vagas deve ser de pelo menos 1.',
        ];
    }
}

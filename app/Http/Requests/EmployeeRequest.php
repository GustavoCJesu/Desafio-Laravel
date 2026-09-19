<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class EmployeeRequest extends FormRequest
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
            'name' => 'max:255|min:5|required|string',
            'cpf' => 'max:14|unique:employees,cpf|required|string',
            'hire_date' => 'required',
            'company_role_id' => 'required|exists:company_roles,id',
            'sector_id' => 'required|exists:sectors,id',
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'name.max' => 'Nome inválido.',
            'name.min' => 'Nome inválido.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve conter apenas texto.',
            'cpf.max' => 'CPF inválido.',
            'cpf.unique' => 'CPF já cadastrado.',
            'cpf.required' => 'O CPF é obrigatório.',
            'hire_date.required' => 'A data de contratação é obrigatória.',
            'sector_id.required' => 'O setor é obrigatório.',
        ];
    }
}

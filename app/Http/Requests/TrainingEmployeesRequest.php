<?php

namespace App\Http\Requests;

use App\Models\SessionTraining;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Override;

class TrainingEmployeesRequest extends FormRequest
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
            'employees' => 'nullable|array',
            'employees.*' => 'exists:employees,id',
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $training = $this->route('sessionTraining');

                if ($training instanceof SessionTraining && count($this->input('employees', [])) > $training->capacity) {
                    $validator->errors()->add('employees', 'Quantidade máxima de convocados atingida.');
                }
            },
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'employees.*.exists' => 'Funcionário inválido.',
        ];
    }
}

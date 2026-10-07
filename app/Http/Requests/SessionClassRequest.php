<?php

namespace App\Http\Requests;

use App\Models\SessionTraining;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
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
            'duration_hours' => 'required|numeric|min:0.25|max:24',
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

                if (! $training instanceof SessionTraining || $validator->errors()->isNotEmpty()) {
                    return;
                }

                $scheduledClasses = $training->classes()->count();

                if ($scheduledClasses >= $training->class_amount) {
                    return;
                }

                $totalHours = round((float) $training->classes()->sum('duration_hours') + (float) $this->input('duration_hours'), 2);

                if ($totalHours > $training->class_min) {
                    $validator->errors()->add('duration_hours', "A soma das aulas ({$totalHours}h) ultrapassa a carga horária da seção ({$training->class_min}h).");
                } elseif ($scheduledClasses + 1 === $training->class_amount && $totalHours < $training->class_min) {
                    $validator->errors()->add('duration_hours', "Esta é a última aula e a soma ({$totalHours}h) ficaria abaixo da carga horária da seção ({$training->class_min}h).");
                }
            },
        ];
    }

    #[Override]
    public function messages(): array
    {
        return [
            'class_dt.required' => 'A data e hora da aula são obrigatórias.',
            'class_dt.date' => 'Data e hora da aula inválidas.',
            'duration_hours.required' => 'A duração da aula é obrigatória.',
            'duration_hours.numeric' => 'A duração da aula deve ser um número de horas.',
            'duration_hours.min' => 'A duração da aula deve ser de pelo menos 15 minutos.',
            'duration_hours.max' => 'A duração da aula não pode passar de 24 horas.',
        ];
    }
}

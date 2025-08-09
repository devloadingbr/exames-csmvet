<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'manager';
    }

    public function rules(): array
    {
        return [
            'exam_type_id' => 'required|exists:exam_types,id',
            'exam_date' => 'required|date|before_or_equal:today',
            'veterinarian_name' => 'required|string|max:255',
            'veterinarian_crmv' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'result_summary' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'exam_type_id.required' => 'O tipo de exame é obrigatório.',
            'exam_type_id.exists' => 'Tipo de exame inválido.',
            'exam_date.required' => 'A data do exame é obrigatória.',
            'exam_date.date' => 'Data do exame inválida.',
            'exam_date.before_or_equal' => 'A data do exame não pode ser futura.',
            'veterinarian_name.required' => 'O nome do veterinário é obrigatório.',
            'veterinarian_name.max' => 'Nome do veterinário muito longo.',
            'veterinarian_crmv.max' => 'CRMV muito longo.',
            'description.max' => 'Observações muito longas.',
            'result_summary.max' => 'Resumo do resultado muito longo.',
        ];
    }
}
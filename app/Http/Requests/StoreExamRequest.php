<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'manager';
    }

    public function rules(): array
    {
        return [
            'exam_type_id' => 'required|exists:exam_types,id',
            'pet_id' => [
                'required',
                'exists:pets,id',
                function ($attribute, $value, $fail) {
                    $pet = \App\Models\Pet::find($value);
                    if ($pet && $pet->clinic_id !== auth()->user()->clinic_id) {
                        $fail('O pet selecionado não pertence à sua clínica.');
                    }
                    if ($pet && $this->client_id && $pet->client_id != $this->client_id) {
                        $fail('O pet selecionado não pertence ao cliente informado.');
                    }
                },
            ],
            'client_id' => [
                'required',
                'exists:clients,id',
                function ($attribute, $value, $fail) {
                    $client = \App\Models\Client::find($value);
                    if ($client && $client->clinic_id !== auth()->user()->clinic_id) {
                        $fail('O cliente selecionado não pertence à sua clínica.');
                    }
                },
            ],
            'exam_date' => 'required|date|before_or_equal:today',
            'veterinarian_name' => 'required|string|max:255',
            'veterinarian_crmv' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'exam_file' => 'required|file|mimes:pdf|max:51200', // 50MB
        ];
    }

    public function messages(): array
    {
        return [
            'exam_type_id.required' => 'O tipo de exame é obrigatório.',
            'exam_type_id.exists' => 'Tipo de exame inválido.',
            'pet_id.required' => 'O pet é obrigatório.',
            'pet_id.exists' => 'Pet não encontrado.',
            'client_id.required' => 'O cliente é obrigatório.',
            'client_id.exists' => 'Cliente não encontrado.',
            'exam_date.required' => 'A data do exame é obrigatória.',
            'exam_date.date' => 'Data do exame inválida.',
            'exam_date.before_or_equal' => 'A data do exame não pode ser futura.',
            'veterinarian_name.required' => 'O nome do veterinário é obrigatório.',
            'veterinarian_name.max' => 'Nome do veterinário muito longo.',
            'veterinarian_crmv.max' => 'CRMV muito longo.',
            'description.max' => 'Observações muito longas.',
            'exam_file.required' => 'O arquivo PDF é obrigatório.',
            'exam_file.file' => 'Arquivo inválido.',
            'exam_file.mimes' => 'Apenas arquivos PDF são aceitos.',
            'exam_file.max' => 'Arquivo muito grande. Máximo 50MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Apenas log para debugging, não alterar dados do formulário
        if ($this->pet_id && $this->client_id) {
            $pet = \App\Models\Pet::find($this->pet_id);
            
            if ($pet && $pet->client_id != $this->client_id) {
                \Log::warning("Inconsistência pet/client detectada", [
                    'pet_id' => $this->pet_id,
                    'pet_client_id' => $pet->client_id,
                    'form_client_id' => $this->client_id,
                    'user_id' => auth()->id(),
                    'clinic_id' => auth()->user()->clinic_id
                ]);
            }
        }
    }
}
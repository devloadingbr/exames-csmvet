<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'manager';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cpf' => [
                'required', 
                'string', 
                'size:14',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                Rule::unique('clients')->where(function ($query) {
                    return $query->where('clinic_id', auth()->user()->clinic_id);
                })
            ],
            'email' => [
                'nullable', 
                'email', 
                'max:255',
                Rule::unique('clients')->where(function ($query) {
                    return $query->where('clinic_id', auth()->user()->clinic_id);
                })
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 14 caracteres (incluindo pontos e hífen).',
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.unique' => 'Este CPF já está cadastrado na sua clínica.',
            'email.email' => 'O email deve ser um endereço válido.',
            'email.unique' => 'Este email já está cadastrado na sua clínica.',
            'phone.max' => 'O telefone não pode ter mais de 20 caracteres.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'address.max' => 'O endereço não pode ter mais de 500 caracteres.',
            'notes.max' => 'As observações não podem ter mais de 1000 caracteres.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Limpar CPF (remover espaços, pontos e hífens para validação)
        if ($this->cpf) {
            $cpf = preg_replace('/[^0-9]/', '', $this->cpf);
            
            // Reformatar CPF
            if (strlen($cpf) === 11) {
                $this->merge([
                    'cpf' => substr($cpf, 0, 3) . '.' . 
                             substr($cpf, 3, 3) . '.' . 
                             substr($cpf, 6, 3) . '-' . 
                             substr($cpf, 9, 2)
                ]);
            }
        }

        // Limpar telefone
        if ($this->phone) {
            $this->merge([
                'phone' => preg_replace('/[^0-9]/', '', $this->phone)
            ]);
        }
    }
}
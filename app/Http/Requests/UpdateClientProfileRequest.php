<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Cliente autenticado pode atualizar seu próprio perfil
        return auth()->guard('client')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $client = auth()->guard('client')->user();

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                'regex:/^[\pL\s\-\.\']+$/u', // Apenas letras, espaços, hífens, pontos e apóstrofes
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:255',
                // Email deve ser único dentro da mesma clínica
                Rule::unique('clients')->where(function ($query) use ($client) {
                    return $query->where('clinic_id', $client->clinic_id);
                })->ignore($client->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^[\(\)\s\-\+\d]+$/', // Formato de telefone flexível
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'city' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[\pL\s\-\.\']+$/u',
            ],
            'state' => [
                'nullable',
                'string',
                'max:2',
                'min:2',
                'regex:/^[A-Z]{2}$/', // Formato UF (ex: SP, RJ)
            ],
            'zip_code' => [
                'nullable',
                'string',
                'regex:/^\d{5}-?\d{3}$/', // CEP com ou sem hífen
            ],
            'receive_email_notifications' => [
                'boolean',
            ],
            'receive_sms_notifications' => [
                'boolean',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',
            'name.regex' => 'O nome deve conter apenas letras, espaços e caracteres básicos.',
            
            'email.email' => 'O email deve ter um formato válido.',
            'email.unique' => 'Este email já está sendo usado por outro cliente.',
            'email.max' => 'O email não pode ter mais que 255 caracteres.',
            
            'phone.max' => 'O telefone não pode ter mais que 20 caracteres.',
            'phone.regex' => 'O telefone deve conter apenas números, parênteses, espaços e hífens.',
            
            'address.max' => 'O endereço não pode ter mais que 500 caracteres.',
            
            'city.max' => 'A cidade não pode ter mais que 100 caracteres.',
            'city.regex' => 'A cidade deve conter apenas letras, espaços e caracteres básicos.',
            
            'state.max' => 'O estado deve ter exatamente 2 caracteres.',
            'state.min' => 'O estado deve ter exatamente 2 caracteres.',
            'state.regex' => 'O estado deve ser uma UF válida (ex: SP, RJ).',
            
            'zip_code.regex' => 'O CEP deve ter o formato 00000-000.',
            
            'receive_email_notifications.boolean' => 'Valor inválido para notificações por email.',
            'receive_sms_notifications.boolean' => 'Valor inválido para notificações por SMS.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'email',
            'phone' => 'telefone',
            'address' => 'endereço',
            'city' => 'cidade',
            'state' => 'estado',
            'zip_code' => 'CEP',
            'receive_email_notifications' => 'notificações por email',
            'receive_sms_notifications' => 'notificações por SMS',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Normalizar telefone
        if ($this->filled('phone')) {
            $phone = preg_replace('/[^\d\(\)\-\+\s]/', '', $this->phone);
            $this->merge(['phone' => $phone]);
        }

        // Normalizar CEP
        if ($this->filled('zip_code')) {
            $zipCode = preg_replace('/[^\d]/', '', $this->zip_code);
            if (strlen($zipCode) === 8) {
                $zipCode = substr($zipCode, 0, 5) . '-' . substr($zipCode, 5);
            }
            $this->merge(['zip_code' => $zipCode]);
        }

        // Normalizar estado para maiúsculo
        if ($this->filled('state')) {
            $this->merge(['state' => strtoupper($this->state)]);
        }

        // Garantir que booleanos sejam tratados corretamente
        $this->merge([
            'receive_email_notifications' => $this->boolean('receive_email_notifications'),
            'receive_sms_notifications' => $this->boolean('receive_sms_notifications'),
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validação customizada de CEP
            if ($this->filled('zip_code') && $this->filled('state')) {
                $cep = preg_replace('/[^\d]/', '', $this->zip_code);
                $estado = $this->state;

                // Validação básica de faixas de CEP por estado (exemplos principais)
                $cepRanges = [
                    'SP' => ['01000', '19999'],
                    'RJ' => ['20000', '28999'],
                    'MG' => ['30000', '39999'],
                    // Adicionar mais estados conforme necessário
                ];

                if (isset($cepRanges[$estado])) {
                    [$min, $max] = $cepRanges[$estado];
                    if ($cep < $min || $cep > $max) {
                        $validator->errors()->add('zip_code', 'CEP não corresponde ao estado informado.');
                    }
                }
            }

            // Validação de telefone brasileiro
            if ($this->filled('phone')) {
                $phoneDigits = preg_replace('/[^\d]/', '', $this->phone);
                if (strlen($phoneDigits) < 10 || strlen($phoneDigits) > 11) {
                    $validator->errors()->add('phone', 'Telefone deve ter 10 ou 11 dígitos.');
                }
            }
        });
    }
}
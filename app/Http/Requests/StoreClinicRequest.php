<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClinicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'superadmin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'size:18', 'unique:clinics,cnpj'],
            'email' => ['required', 'email', 'max:255', 'unique:clinics,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'plan_id' => ['required', 'exists:plans,id'],
            'primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_domain' => ['nullable', 'string', 'max:255', 'unique:clinics,custom_domain'],
            'is_active' => ['boolean'],
            
            // Dados do gestor
            'manager_name' => ['nullable', 'string', 'max:255'],
            'manager_email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'manager_password' => ['nullable', 'string', 'min:6'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da clínica é obrigatório.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.size' => 'O CNPJ deve ter exatamente 18 caracteres (com pontuação).',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'Este email já está cadastrado.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'state.size' => 'O estado deve ter exatamente 2 caracteres.',
            'plan_id.required' => 'É necessário selecionar um plano.',
            'plan_id.exists' => 'O plano selecionado não existe.',
            'primary_color.regex' => 'A cor primária deve estar no formato hexadecimal (#RRGGBB).',
            'secondary_color.regex' => 'A cor secundária deve estar no formato hexadecimal (#RRGGBB).',
            'custom_domain.unique' => 'Este domínio personalizado já está em uso.',
            'manager_email.unique' => 'Este email de gestor já está cadastrado.',
            'manager_password.min' => 'A senha do gestor deve ter pelo menos 6 caracteres.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpar CNPJ (remover pontuação para validação)
        if ($this->cnpj) {
            $this->merge([
                'cnpj' => preg_replace('/[^0-9]/', '', $this->cnpj)
            ]);
        }

        // Garantir que is_active seja boolean
        $this->merge([
            'is_active' => $this->boolean('is_active', true)
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validação customizada de CNPJ
            if ($this->cnpj && !$this->isValidCNPJ($this->cnpj)) {
                $validator->errors()->add('cnpj', 'O CNPJ informado não é válido.');
            }

            // Se informou dados do gestor, todos os campos são obrigatórios
            if ($this->filled('manager_name') || $this->filled('manager_email')) {
                if (!$this->filled('manager_name')) {
                    $validator->errors()->add('manager_name', 'O nome do gestor é obrigatório.');
                }
                if (!$this->filled('manager_email')) {
                    $validator->errors()->add('manager_email', 'O email do gestor é obrigatório.');
                }
                if (!$this->filled('manager_password')) {
                    $validator->errors()->add('manager_password', 'A senha do gestor é obrigatória.');
                }
            }
        });
    }

    /**
     * Valida CNPJ usando algoritmo oficial
     */
    private function isValidCNPJ(string $cnpj): bool
    {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se tem 14 dígitos
        if (strlen($cnpj) !== 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Calcula primeiro dígito verificador
        $sum = 0;
        $weights = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($i = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        
        $remainder = $sum % 11;
        $digit1 = $remainder < 2 ? 0 : 11 - $remainder;
        
        if ($cnpj[12] != $digit1) {
            return false;
        }

        // Calcula segundo dígito verificador
        $sum = 0;
        $weights = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        for ($i = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $weights[$i];
        }
        
        $remainder = $sum % 11;
        $digit2 = $remainder < 2 ? 0 : 11 - $remainder;
        
        return $cnpj[13] == $digit2;
    }
}

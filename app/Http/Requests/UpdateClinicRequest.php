<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClinicRequest extends FormRequest
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
        $clinicId = $this->route('clinic')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'size:14', Rule::unique('clinics')->ignore($clinicId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('clinics')->ignore($clinicId)],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'zip_code' => ['nullable', 'string', 'max:10'],
            'plan_id' => ['required', 'exists:plans,id'],
            'primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'custom_domain' => ['nullable', 'string', 'max:255', Rule::unique('clinics')->ignore($clinicId)],
            'subscription_status' => ['required', 'in:trial,active,suspended,cancelled'],
            'trial_ends_at' => ['nullable', 'date'],
            'subscription_ends_at' => ['nullable', 'date'],
            'is_active' => ['boolean'],
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
            'cnpj.size' => 'O CNPJ deve ter exatamente 14 dígitos.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'Este email já está cadastrado.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'state.size' => 'O estado deve ter exatamente 2 caracteres.',
            'plan_id.required' => 'É necessário selecionar um plano.',
            'plan_id.exists' => 'O plano selecionado não existe.',
            'subscription_status.required' => 'O status da assinatura é obrigatório.',
            'subscription_status.in' => 'Status de assinatura inválido.',
            'primary_color.regex' => 'A cor primária deve estar no formato hexadecimal (#RRGGBB).',
            'secondary_color.regex' => 'A cor secundária deve estar no formato hexadecimal (#RRGGBB).',
            'custom_domain.unique' => 'Este domínio personalizado já está em uso.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Limpar CNPJ (remover pontuação)
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
}

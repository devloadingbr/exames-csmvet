<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'manager';
    }

    public function rules(): array
    {
        return [
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')->where(function ($query) {
                    return $query->where('clinic_id', auth()->user()->clinic_id);
                })
            ],
            'name' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:100'],
            'breed' => ['nullable', 'string', 'max:150'],
            'gender' => ['nullable', 'in:Macho,Fêmea'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:999.99'],
            'color' => ['nullable', 'string', 'max:100'],
            'microchip' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'O cliente é obrigatório.',
            'client_id.exists' => 'Cliente não encontrado ou não pertence à sua clínica.',
            'name.required' => 'O nome do pet é obrigatório.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'species.required' => 'A espécie é obrigatória.',
            'species.max' => 'A espécie não pode ter mais de 100 caracteres.',
            'breed.max' => 'A raça não pode ter mais de 150 caracteres.',
            'gender.in' => 'O sexo deve ser Macho ou Fêmea.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
            'weight.numeric' => 'O peso deve ser um número.',
            'weight.min' => 'O peso não pode ser negativo.',
            'weight.max' => 'O peso não pode ser maior que 999.99 kg.',
            'color.max' => 'A cor não pode ter mais de 100 caracteres.',
            'microchip.max' => 'O microchip não pode ter mais de 50 caracteres.',
            'notes.max' => 'As observações não podem ter mais de 1000 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'client_id' => 'cliente',
            'name' => 'nome',
            'species' => 'espécie',
            'breed' => 'raça',
            'gender' => 'sexo',
            'birth_date' => 'data de nascimento',
            'weight' => 'peso',
            'color' => 'cor',
            'microchip' => 'microchip',
            'notes' => 'observações',
        ];
    }
}
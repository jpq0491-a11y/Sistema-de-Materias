<?php

namespace App\Http\Requests;

use App\Models\Horario;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MateriaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'creditos' => ['required', 'integer', 'min:1', 'max:20'],
            'profesor' => ['required', 'string', 'max:255'],
            'horarios' => ['nullable', 'array', 'max:14'],
            'horarios.*.dia' => ['required', 'integer', Rule::in(array_keys(Horario::DIAS))],
            'horarios.*.hora_inicio' => ['required', 'date_format:H:i'],
            'horarios.*.hora_fin' => ['required', 'date_format:H:i', 'after:horarios.*.hora_inicio'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'horarios.*.dia' => 'día',
            'horarios.*.hora_inicio' => 'hora de inicio',
            'horarios.*.hora_fin' => 'hora de fin',
        ];
    }
}

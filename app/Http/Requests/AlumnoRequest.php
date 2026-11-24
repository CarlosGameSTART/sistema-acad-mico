<?php

namespace App\Http\Requests;

use App\Models\Alumno;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlumnoRequest extends FormRequest
{
    /**
     * Protección en backend: solo un profesor puede registrar o modificar.
     */
    public function authorize(): bool
    {
        return $this->user() !== null && $this->user()->isProfesor();
    }

    public function rules(): array
    {
        /** @var Alumno|null $alumno */
        $alumno = $this->route('alumno');
        $esNuevo = $alumno === null;

        return [
            'nombre' => ['required', 'string', 'min:3', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($alumno?->user_id),
            ],
            'password' => [
                $esNuevo ? 'required' : 'nullable',
                'string',
                'min:8',
            ],
            'faltas' => ['required', 'integer', 'min:0', 'max:'.Alumno::FALTAS_MAX],
            'calificacion' => [
                'required',
                'numeric',
                'decimal:0,2',
                'min:0',
                'max:'.Alumno::CALIFICACION_MAX,
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del alumno es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Escribe un correo válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria para un alumno nuevo.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'faltas.required' => 'El número de faltas es obligatorio.',
            'faltas.integer' => 'Las faltas deben ser un número entero.',
            'faltas.min' => 'Las faltas no pueden ser negativas.',
            'faltas.max' => 'Las faltas no pueden ser mayores a '.Alumno::FALTAS_MAX.'.',
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.numeric' => 'La calificación debe ser numérica.',
            'calificacion.decimal' => 'La calificación admite máximo 2 decimales.',
            'calificacion.min' => 'La calificación mínima es 0.',
            'calificacion.max' => 'La calificación máxima es '.Alumno::CALIFICACION_MAX.'.',
        ];
    }
}

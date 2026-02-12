<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user'); // ID del usuario que se está editando

        return [
            'identificador' => [
                'required',
                'numeric',
                Rule::unique('users', 'identificador')->ignore($userId)
            ],
            // Email y cédula NO se pueden cambiar, por eso no están aquí
            'password' => [
                'nullable', // Opcional al editar
                'string',
                'min:8',
                'regex:/[0-9]/',
                'regex:/[A-Z]/',
                'regex:/[@$!%*#?&]/',
                'confirmed'
            ],
            'nombre' => 'required|string|max:100',
            'numero_celular' => 'nullable|digits:10',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:-18 years'
            ],
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'identificador.required' => 'El identificador es obligatorio.',
            'identificador.numeric' => 'El identificador debe ser numérico.',
            'identificador.unique' => 'Este identificador ya está registrado.',
            
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos un número, una mayúscula y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            
            'numero_celular.digits' => 'El número celular debe tener 10 dígitos.',
            
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'Debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años.',
            
            'country_id.required' => 'El país es obligatorio.',
            'state_id.required' => 'El estado es obligatorio.',
            'city_id.required' => 'La ciudad es obligatoria.',
        ];
    }
}

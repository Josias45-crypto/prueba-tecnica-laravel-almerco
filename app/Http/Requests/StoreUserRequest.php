<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Solo admin puede acceder, verificado por middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identificador' => 'required|numeric|unique:users,identificador',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[0-9]/',      // Debe contener al menos un número
                'regex:/[A-Z]/',      // Debe contener al menos una mayúscula
                'regex:/[@$!%*#?&]/', // Debe contener al menos un carácter especial
                'confirmed'
            ],
            'nombre' => 'required|string|max:100',
            'numero_celular' => 'nullable|digits:9',
            'cedula' => 'required|string|max:11',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:-18 years' // Debe ser mayor de 18 años
            ],
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'identificador.required' => 'El identificador es obligatorio.',
            'identificador.numeric' => 'El identificador debe ser numérico.',
            'identificador.unique' => 'Este identificador ya está registrado.',
            
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos un número, una mayúscula y un carácter especial.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres.',
            
            'numero_celular.digits' => 'El número celular debe tener 9 dígitos.',
            
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.max' => 'La cédula no puede exceder 11 caracteres.',
            
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'Debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años.',
            
            'country_id.required' => 'El país es obligatorio.',
            'country_id.exists' => 'El país seleccionado no es válido.',
            
            'state_id.required' => 'El estado es obligatorio.',
            'state_id.exists' => 'El estado seleccionado no es válido.',
            
            'city_id.required' => 'La ciudad es obligatoria.',
            'city_id.exists' => 'La ciudad seleccionada no es válida.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest
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
        return [
            'nameUser' => ['required', 'string', 'max:255'],
            'emailUser' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'passUser' => ['required','min:8','regex:/^(?=.*[A-Z])(?=.*\d).+$/'],
        ];
    }

    public function messages(){
        return [
            'nameUser.required' => 'El nombre del usuario es obligatorio',
            'emailUser.required' => 'El correo electrónico es obligatorio',
            'emailUser.email' => 'El correo electrónico debe ser válido',
            'emailUser.unique' => 'El correo electrónico ya está en uso',
            'passUser.required' => 'La contraseña es obligatoria',
            'passUser.min' => 'La contraseña debe tener al menos :min caracteres',
            'passUser.regex' => 'La contraseña debe contener al menos una letra mayúscula y un número.'
        ];
    }
}

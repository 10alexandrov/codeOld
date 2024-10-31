<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to this request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nameLocal' => ['required', 'min:3', 'regex:/^[^\d]+$/'],
            'dbConexion' => ['required', 'array'],
            'dbConexion.*.id' => ['nullable', 'numeric'],
            'dbConexion.*.name' => ['required'],
            'dbConexion.*.ip' => ['required', 'regex:/^\b(?:\d{1,3}\.){3}\d{1,3}\b$/'],
            'dbConexion.*.port' => ['required', 'numeric', 'min:1', 'max:65535'],
            'dbConexion.*.database' => ['required', 'regex:/^[^\d]+$/'],
            'dbConexion.*.username' => ['required'],
            'dbConexion.*.password' => ['required'],
            'machine_id' => ['numeric', 'min:1', 'max:999999999'],
        ];
    }

    /**
     * Get custom validation messages for this request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nameLocal.required' => 'El nombre del local es obligatorio',
            'nameLocal.min' => 'El nombre del local debe tener al menos :min caracteres',
            'nameLocal.regex' => 'El nombre del local no puede contener números',

            'machine_id.required' => 'El ID de la máquina es obligatorio',
            'machine_id.numeric' => 'El ID de la máquina debe ser numérico',
            'machine_id.min' => 'El ID de la máquina debe tener al menos :min dígitos',
            'machine_id.max' => 'El ID de la máquina debe tener como máximo :max dígitos',

            'dbConexion.required' => 'Debe proporcionar al menos una conexión',
            'dbConexion.array' => 'Las conexiones deben ser un array',

            'dbConexion.*.name.required' => 'El nombre de la conexión es obligatorio',
            'dbConexion.*.ip.required' => 'La IP de la conexión es obligatoria',
            'dbConexion.*.ip.regex' => 'La IP debe ser en formato correcto (e.g., 192.168.1.1)',
            'dbConexion.*.port.required' => 'El puerto de la conexión es obligatorio',
            'dbConexion.*.port.numeric' => 'El puerto debe ser numérico',
            'dbConexion.*.port.min' => 'El puerto debe ser al menos :min',
            'dbConexion.*.port.max' => 'El puerto debe ser como máximo :max',
            'dbConexion.*.database.required' => 'El nombre de la base de datos es obligatorio',
            'dbConexion.*.username.required' => 'El usuario es obligatorio',
            'dbConexion.*.password.required' => 'La contraseña es obligatoria',
        ];
    }
}

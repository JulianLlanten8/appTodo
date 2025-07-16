<?php

namespace Modules\InterfaceAdapters\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteTaskRequest extends FormRequest
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
            'id' => 'required|integer|exists:tasks,id', // Validación para asegurarse de que el ID sea un entero y exista en la tabla tasks
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'id.required' => 'El ID de la tarea es obligatorio.',
            'id.integer' => 'El ID debe ser un número entero.',
            'id.exists' => 'La tarea con el ID proporcionado no existe.',
        ];
    }
}

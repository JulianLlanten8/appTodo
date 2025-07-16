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
        // usa un merge para combinar las reglas de validación de la ruta y del cuerpo de la solicitud
        return [
            'id' => 'required|integer|exists:tasks,id',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Fusiona el parámetro 'id' de la ruta en los datos del request
        $this->getInputSource()->add([
            'id' => $this->route('id'), // Obtiene el parámetro de ruta 'id'
        ]);
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

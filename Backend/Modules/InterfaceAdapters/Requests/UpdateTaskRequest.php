<?php

namespace Modules\InterfaceAdapters\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255', // 'sometimes' para que sea opcional, pero si se envía, 'required'
            'description' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|string|in:pending,completed,in_progress', // Ejemplo de valores permitidos
            'color' => 'sometimes|nullable|string',
            'priority' => 'sometimes|required|integer|min:1|max:5',
            'due_date' => 'sometimes|nullable|date', // Acepta cualquier formato de fecha válido
        ];
    }

    /**
     * Get the validated data from the request, including route parameters.
     */
    public function validationData(): array
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'), // Incluye el ID de la ruta en los datos de validación
        ]);
    }

    /**
     * Get the validated data with defaults applied (excluding the ID for updates).
     */
    public function getValidatedDataWithDefaults(): array
    {
        $validated = $this->validated();

        // Remover el ID de los datos validados para actualizaciones
        // ya que no debe ser parte de los datos a actualizar
        unset($validated['id']);

        return $validated;
    }

    /**
     * Get custom messages for validation errors.
     * (Opcional, para mensajes de error personalizados)
     */
    public function messages(): array
    {
        return [
            'id.required' => 'El ID de la tarea es obligatorio.',
            'id.integer' => 'El ID debe ser un número entero.',
            'id.exists' => 'La tarea con el ID proporcionado no existe.',
            'title.required' => 'El título de la tarea es obligatorio.',
            'status.in' => 'El estado de la tarea debe ser "pending", "completed" o "in_progress".',
            'priority.min' => 'La prioridad debe ser al menos 1.',
            'due_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
        ];
    }
}

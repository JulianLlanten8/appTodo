<?php

namespace Modules\InterfaceAdapters\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'nullable|string|in:pending,completed',
            'color' => 'nullable|string|max:7',
            'priority' => 'nullable|integer|min:1|max:5',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Merge the request data with the input source
        $this->merge([
            'title' => $this->input('title'),
            'description' => $this->input('description'),
            'due_date' => $this->input('due_date'),
            'status' => $this->input('status', 'pending'),
            'color' => $this->input('color'),
            'priority' => $this->input('priority', 1),
        ]);
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título de la tarea es obligatorio.',
            'title.string' => 'El título debe ser una cadena de texto.',
            'title.max' => 'El título no puede exceder los 255 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'due_date.date' => 'La fecha de vencimiento debe ser una fecha válida.',
            'status.string' => 'El estado debe ser una cadena de texto.',
            'status.in' => 'El estado debe ser uno de los siguientes: pending, completed.',
            'color.string' => 'El color debe ser una cadena de texto.',
            'color.max' => 'El color no puede exceder los 7 caracteres.',
            'priority.integer' => 'La prioridad debe ser un número entero.',
            'priority.min' => 'La prioridad debe ser al menos 1.',
            'priority.max' => 'La prioridad no puede ser mayor a 5.',
        ];
    }
}

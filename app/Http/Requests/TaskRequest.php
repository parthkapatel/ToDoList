<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'description' => 'required',
            'due_date' => 'required|date',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Please enter task title',
            'title.string' => 'Please enter valid title',
            'title.max' => 'Task title must be in 255 character',
            'description.required' => 'Please enter task description',
            'due_date.required' => 'Please select due date',
            'due_date.date' => 'Please select valid due date',
            'category_id.required' => 'Please select category',
            'category_id.exists' => 'The selected category does not exist',
        ];
    }
}

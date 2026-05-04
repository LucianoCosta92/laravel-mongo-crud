<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'status'      => ['required', new Enum(TaskStatus::class)],
            'priority'    => ['required', new Enum(TaskPriority::class)],
            'due_date'    => 'nullable|date|after_or_equal:today',
            'category_id' => 'nullable|string',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:50',
        ];
    }
}

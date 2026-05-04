<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'sometimes|string|max:255',
            'description'  => 'sometimes|nullable|string|max:2000',
            'status'       => ['sometimes', new Enum(TaskStatus::class)],
            'priority'     => ['sometimes', new Enum(TaskPriority::class)],
            'due_date'     => 'sometimes|nullable|date',
            'completed_at' => 'sometimes|nullable|date',
            'category_id'  => 'sometimes|nullable|string',
            'tags'         => 'sometimes|nullable|array',
            'tags.*'       => 'string|max:50',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->request->remove('user_id');
        $this->request->remove('_id');
    }
}

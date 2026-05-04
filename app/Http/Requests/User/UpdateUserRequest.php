<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'name'                  => 'sometimes|string|max:150',
            'email'                 => "sometimes|email|unique:users,email,{$userId},_id",
            'password'              => 'sometimes|nullable|string|min:6|confirmed',
            'password_confirmation' => 'sometimes|nullable|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->request->remove('_id');
    }
}

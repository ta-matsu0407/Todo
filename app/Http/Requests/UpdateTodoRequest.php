<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;


class UpdateTodoRequest extends FormRequest
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
            'homework' => ['required', 'max:255'],
            'deadline' => ['required', 'date'],
            'memo' => ['max:255'],
            'status' => ['required', new Enum(Status::class)], // Status Enumでバリデーション
        ];
    }
}

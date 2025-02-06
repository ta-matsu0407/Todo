<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Gender;
use App\Enums\Status;
use Illuminate\Validation\Rules\Enum;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'kana' => ['required', 'regex:/^[ァ-ヾ ]+$/u','max:50'],
            'tel' => ['required', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'postcode' => ['required', 'max:7'],
            'address' => ['required', 'max:100'],
            'birthday' => ['required', 'date'],
            'password' => ['required'],
            'memo' => ['max:1000'],
            'gender' => ['required', new Enum(Gender::class)], // Gender Enumでバリデーション
        ];
    }
}

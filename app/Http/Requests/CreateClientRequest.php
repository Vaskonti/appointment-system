<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'timezone' => ['required', 'string', 'timezone', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:clients,phone'],
            'reminder_offset_minutes' => ['nullable', 'integer', 'min:0'],
            'reminder_method' => ['nullable', 'string', 'in:email,sms'],
        ];
    }
}

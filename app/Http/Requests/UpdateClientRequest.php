<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'timezone' => ['sometimes', 'string', 'timezone', 'max:50'],
            'email' => ['sometimes', 'string', 'email', 'max:255', 'unique:clients,email,' . $this->route('client')->id],
            'phone' => ['sometimes', 'string', 'max:20', 'unique:clients,phone,' . $this->route('client')->id],
            'reminder_offset_minutes' => ['sometimes', 'integer', 'min:0'],
            'reminder_method' => ['sometimes', 'string', 'in:email,sms'],
            'user_id' => ['sometimes', 'exists:users,id'],
        ];
    }
}

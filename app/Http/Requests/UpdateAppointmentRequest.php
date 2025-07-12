<?php

namespace App\Http\Requests;

use App\Constants\AppointmentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'date_time' => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'status' => ['sometimes', Rule::in(AppointmentStatus::all())],
            'reminder_offset_minutes' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}

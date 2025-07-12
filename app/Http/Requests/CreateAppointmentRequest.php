<?php

namespace App\Http\Requests;

use App\Constants\AppointmentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAppointmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'client_id' => ['required', 'exists:clients,id'],
            'date_time' => ['required', 'date', 'after_or_equal:now'],
            'status' => ['required', 'string', Rule::in(AppointmentStatus::all())],
            'reminder_offset_minutes' => ['nullable', 'integer', 'min:0'],
            'reminder_offsets' => ['array'],
            'reminder_offsets.*.offset_minutes' => ['required', 'integer', 'min:0'],
            'reminder_offsets.*.timezone' => ['required', 'string'],
            'reminder_offsets.*.enabled' => ['required', 'boolean'],
            'reminder_offsets.*.recurrence' => ['nullable', 'string'],
            'reminder_offsets.*.recurrence_interval' => ['nullable', 'integer', 'min:1'],
            'reminder_offsets.*.max_recurrences' => ['nullable', 'integer', 'min:1'],
        ];
    }
}

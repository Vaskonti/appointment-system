<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReminderOffsets extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'reminder_offsets';

    protected $fillable = [
        'appointment_id',
        'offset_minutes',
        'timezone',
        'enabled',
        'recurrence',
        'recurrence_interval',
        'max_recurrences'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'offset_minutes' => 'integer',
            'enabled' => 'boolean',
            'recurrence' => 'string',
            'recurrence_interval' => 'integer',
            'max_recurrences' => 'integer',
        ];
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}

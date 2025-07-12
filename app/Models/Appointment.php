<?php

namespace App\Models;

use App\Constants\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'client_id',
        'title',
        'date_time',
        'status',
        'length_minutes',
    ];

    protected function casts(): array
    {
        return [
            'date_time' => 'datetime',
            'reminder_offset_minutes' => 'integer',
            'status' => AppointmentStatus::class,
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reminderOffsets(): HasMany
    {
        return $this->hasMany(ReminderOffsets::class);
    }
}

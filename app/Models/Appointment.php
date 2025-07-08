<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'client_id',
        'title',
        'date_time',
        'reminder_offset_minutes',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}

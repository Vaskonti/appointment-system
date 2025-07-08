<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'timezone',
        'email',
        'phone',
        'reminder_offset_minutes',
        'reminder_method', // 'email' or 'sms'
        'user_id',
    ];

    /**
     * Get the appointments for the client.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

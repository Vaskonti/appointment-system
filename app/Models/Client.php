<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'timezone',
        'email',
        'phone',
    ];

    /**
     * Get the appointments for the client.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}

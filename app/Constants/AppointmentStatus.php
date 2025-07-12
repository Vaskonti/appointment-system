<?php

namespace App\Constants;

enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case MISSED = 'missed';

    public static function all(): array
    {
        return [
            self::SCHEDULED->value,
            self::COMPLETED->value,
            self::CANCELLED->value,
            self::MISSED->value,
        ];
    }
}

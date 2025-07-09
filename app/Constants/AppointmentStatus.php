<?php

namespace App\Constants;

class AppointmentStatus extends BaseConstant
{
    public const SCHEDULED = 'scheduled';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
    public const MISSED = 'missed';
}
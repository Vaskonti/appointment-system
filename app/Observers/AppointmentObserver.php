<?php

namespace App\Observers;

use App\Models\Appointment;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        $client = $appointment->client;
        $appointmentTimeUTC = Carbon::parse($appointment->date_time)->timezone(\DateTimeZone::UTC);

        $reminderTimeUTC = $appointmentTimeUTC->subMinutes($client->reminder_offset_minutes);

        if ($reminderTimeUTC->isFuture()) {
            $client->notify(new AppointmentNotification($appointment))->delay($reminderTimeUTC);
        }
    }

    /**
     * Handle the Appointment "updated" event.
     */
    public function updated(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "deleted" event.
     */
    public function deleted(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "restored" event.
     */
    public function restored(Appointment $appointment): void
    {
        //
    }

    /**
     * Handle the Appointment "force deleted" event.
     */
    public function forceDeleted(Appointment $appointment): void
    {
        //
    }
}

<?php

namespace App\Observers;

use App\Jobs\ReminderDispatch;
use App\Models\Appointment;
use App\Models\Client;
use App\Notifications\AppointmentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentObserver
{
    /**
     * Handle the Appointment "created" event.
     */
    public function created(Appointment $appointment): void
    {
        /** @var Client $client */
        $client = $appointment->client;
        $appointmentTimeUTC = Carbon::parse($appointment->date_time)->timezone('UTC');

        $reminderTimeUTC = $appointmentTimeUTC->subMinutes($client->reminder_offset_minutes);

        if ($reminderTimeUTC->isFuture()) {
           ReminderDispatch::dispatch($client, $appointment)->delay(
                $reminderTimeUTC
            );
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

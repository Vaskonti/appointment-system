<?php

namespace App\Observers;

use App\Jobs\ReminderDispatch;
use App\Models\ReminderOffsets;

class ReminderOffsetsObserver
{
    /**
     * Handle the ReminderOffsets "created" event.
     */
    public function created(ReminderOffsets $reminderOffsets): void
    {
        if (!$reminderOffsets->enabled) {
            return;
        }
        $appointment = $reminderOffsets->appointment;
        $reminderTimeUTC = $appointment->date_time->subMinutes($reminderOffsets->offset_minutes)->timezone('UTC');

        for ($i = 1; $i <= $reminderOffsets->max_recurrence; $i++) {
            $reminderTime = match ($reminderOffsets->recurrence) {
                'daily' => $reminderTimeUTC->addDay($i),
                'weekly' => $reminderTimeUTC->addWeek($i),
                'monthly' => $reminderTimeUTC->addMonth($i + $reminderOffsets->recurrence_interval),
                default => $reminderTimeUTC,
            };

            if ($reminderTime->isFuture()) {
                // Dispatch the reminder job with the calculated delay
                ReminderDispatch::dispatch($appointment->client, $appointment)
                    ->delay($reminderTime);
            }
        }
    }

    /**
     * Handle the ReminderOffsets "updated" event.
     */
    public function updated(ReminderOffsets $reminderOffsets): void
    {
        //
    }

    /**
     * Handle the ReminderOffsets "deleted" event.
     */
    public function deleted(ReminderOffsets $reminderOffsets): void
    {
        //
    }

    /**
     * Handle the ReminderOffsets "restored" event.
     */
    public function restored(ReminderOffsets $reminderOffsets): void
    {
        //
    }

    /**
     * Handle the ReminderOffsets "force deleted" event.
     */
    public function forceDeleted(ReminderOffsets $reminderOffsets): void
    {
        //
    }
}

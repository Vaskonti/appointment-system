<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\Client;
use App\Notifications\AppointmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ReminderDispatch implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Client $client,
        private readonly Appointment $appointment
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->client->notify(new AppointmentNotification($this->appointment));
        } catch (\Exception $e) {
            Log::error('Failed to send appointment reminder: ' . $e->getMessage());
            return;
        }
    }
}

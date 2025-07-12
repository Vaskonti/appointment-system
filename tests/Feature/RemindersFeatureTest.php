<?php

use App\Jobs\ReminderDispatch;
use App\Models\Client;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $this->user = \App\Models\User::factory()->create();
});
it('can dispatch a job in the queue', closure: function () {
    Queue::fake();
    $client = Client::factory()->create(['user_id' => $this->user->id]);
    $appointment = \App\Models\Appointment::factory()->create([
        'client_id' => $client->id,
        'date_time' => now()->addMinutes(30),
        'status' => \App\Constants\AppointmentStatus::SCHEDULED,
    ]);

    $job = new ReminderDispatch($client, $appointment);

    Queue::push($job);
    Queue::assertPushed(ReminderDispatch::class);
});

<?php

use App\Constants\AppointmentStatus;
use App\Jobs\ReminderDispatch;
use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

beforeEach(function () {
    $user = User::factory()->create();
    $this->user = $user;
    $this->actingAs($this->user, 'api');
    $this->client = Client::factory()->create(['user_id' => $user->id]);
});

it('can create an appointment', function () {
    $response = $this->postJson('/api/appointments', [
        'title' => 'Test Appointment',
        'date_time' => '2025-10-01 10:00:00',
        'client_id' => $this->client->id,
        'status' => AppointmentStatus::SCHEDULED,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'appointment' => [
                'client_id',
                'title',
                'date_time',
            ]]);
});

it('can schedule a new job', function () {
    Queue::fake();
    $response = $this->postJson('/api/appointments', [
        'title' => 'Test Appointment',
        'date_time' => '2025-10-01 10:00:00',
        'client_id' => $this->client->id,
        'status' => AppointmentStatus::SCHEDULED,
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'appointment' => [
                'client_id',
                'title',
                'date_time',
            ],
        ]);
    Queue::assertPushed(
        ReminderDispatch::class,
    );

});

it('can retrieve an appointment by ID', function () {
    $appointment = Appointment::factory()->create(['client_id' => $this->client->id, 'status' => AppointmentStatus::SCHEDULED]);

    $response = $this->getJson("/api/appointments/{$appointment->id}");

    $response->assertStatus(200)
        ->assertJsonStructure([
            'appointment' => [
                'id',
                'client_id',
                'title',
                'date_time',
                'status',
            ],
            'client' => [
                'name',
                'timezone',
                'email',
                'phone',
                'reminder_offset_minutes',
                'reminder_method',
            ],
        ]);
});

it('can update an appointment', function () {
    $appointment = Appointment::factory()->create(['client_id' => $this->client->id, 'status' => AppointmentStatus::SCHEDULED->value]);
    $response = $this->putJson("/api/appointments/{$appointment->id}", [
        'title' => 'Updated Appointment',
        'date_time' => '2025-10-01 11:00:00',
        'status' => AppointmentStatus::COMPLETED->value,
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'appointment' => [
                'client_id',
                'title',
                'date_time',
                'status',
            ],
        ]);
});

it('can delete an appointment', function () {
    $appointment = Appointment::factory()->create(['client_id' => $this->client->id]);
    $response = $this->deleteJson("/api/appointments/{$appointment->id}");
    $response->assertStatus(204);

    $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
});

it('can list all appointments for the authenticated user', function () {
    Appointment::factory()->count(3)->create(['client_id' => $this->client->id, 'status' => AppointmentStatus::SCHEDULED->value]);

    $response = $this->getJson('/api/appointments');

    $response->assertStatus(200)
        ->assertJsonCount(1, 'clients')
        ->assertJsonStructure(['clients' => [
            [
                'name',
                'timezone',
                'email',
                'phone',
                'reminder_offset_minutes',
                'reminder_method',
                'appointments' => [
                    '*' => [
                        'id',
                        'title',
                        'date_time',
                        'status',
                    ],
                ],
            ],
        ]]);
});

it('can get past appointments', function () {
    Appointment::factory()->create([
        'client_id' => $this->client->id,
        'date_time' => now()->subDays(10),
        'status' => AppointmentStatus::COMPLETED->value,
    ]);

    $response = $this->getJson('/api/past-appointments/' . $this->client->id);

    $response->assertStatus(200)
        ->assertJsonStructure(['appointments' => [
            '*' => [
                'id',
                'title',
                'date_time',
                'status',
            ],
        ]]);
});

it('can get upcoming appointments', function () {
    Appointment::factory()->create([
        'client_id' => $this->client->id,
        'date_time' => now()->addDays(10),
        'status' => AppointmentStatus::SCHEDULED->value,
    ]);

    $response = $this->getJson('/api/upcoming-appointments/' . $this->client->id);

    $response->assertStatus(200)
        ->assertJsonStructure(['appointments' => [
            '*' => [
                'id',
                'title',
                'date_time',
                'status',
            ],
        ]]);
});

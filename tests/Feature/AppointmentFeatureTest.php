<?php

it('can create an appointment', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'api');

    $response = $this->postJson('/api/appointments', [
        'date' => '2023-10-01',
        'time' => '10:00:00',
        'status' => \App\Constants\AppointmentStatus::SCHEDULED,
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['id', 'date', 'time', 'status']);
});

it('can retrieve an appointment by ID', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'api');

    $appointment = \App\Models\Appointment::factory()->create();

    $response = $this->getJson("/api/appointments/{$appointment->id}");

    $response->assertStatus(200)
             ->assertJsonStructure(['id', 'date', 'time', 'status'])
             ->assertJson(['id' => $appointment->id]);
});

it('can update an appointment', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'api');
    $appointment = \App\Models\Appointment::factory()->create();
    $newDate = '2023-10-02';

    $newTime = '11:00:00';
    $newStatus = \App\Constants\AppointmentStatus::COMPLETED;
    $response = $this->putJson("/api/appointments/{$appointment->id}", [
        'date' => $newDate,
        'time' => $newTime,
        'status' => $newStatus,
    ]);
    $response->assertStatus(200)
             ->assertJsonStructure(['id', 'date', 'time', 'status'])
             ->assertJson([
                 'id' => $appointment->id,
                 'date' => $newDate,
                 'time' => $newTime,
                 'status' => $newStatus,
             ]);
});

it('can delete an appointment', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'api');
    $appointment = \App\Models\Appointment::factory()->create();
    $response = $this->deleteJson("/api/appointments/{$appointment->id}");
    $response->assertStatus(204);

    $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
});

it('can list all appointments for the authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user, 'api');

    $appointments = \App\Models\Appointment::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->getJson('/api/appointments');

    $response->assertStatus(200)
             ->assertJsonCount(3, 'data')
             ->assertJsonStructure(['data' => [['id', 'date', 'time', 'status']]]);
});

<?php

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach( function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'api');
});

it('can create a client for a user', function () {
    $response = $this->postJson('/api/clients', [
        'timezone' => 'Europe/London',
        'name' => 'Test Client',
        'reminder_offset_minutes' => 30,
        'reminder_method' => 'email',
        'email' => 'test@example.com',
        'phone' => '1234567890',
    ]);

    $response->assertStatus(201)
             ->assertJsonStructure(['client' => [
                 'id',
                 'name',
                 'timezone',
                 'email',
                 'phone',
                 'reminder_offset_minutes',
                 'reminder_method',
             ]]);
});

it('can get all clients for a user', function () {
    Client::factory()->count(3)->create(['user_id' => Auth::id()]);

    $response = $this->getJson('/api/clients');

    $response->assertStatus(200)
             ->assertJsonStructure(['clients' => [
                 '*' => [
                     'id',
                     'name',
                     'timezone',
                     'email',
                     'phone',
                     'reminder_offset_minutes',
                     'reminder_method',
                 ],
             ]]);
});

it('can update client properties', function () {
    $client = Client::factory()->create(['user_id' => Auth::id()]);

    $response = $this->putJson("/api/clients/{$client->id}", [
        'name' => 'Updated Client Name',
        'timezone' => 'America/New_York',
        'reminder_offset_minutes' => 45,
        'reminder_method' => 'sms',
    ]);

    $response->assertStatus(200)
             ->assertJson([
                 'message' => 'Client updated successfully',
                 'client' => [
                     'id' => $client->id,
                     'name' => 'Updated Client Name',
                     'timezone' => 'America/New_York',
                     'reminder_offset_minutes' => 45,
                     'reminder_method' => 'sms',
                 ],
             ]);
});

it('can delete a client', function () {
    $client = Client::factory()->create(['user_id' => Auth::id()]);

    $response = $this->deleteJson("/api/clients/{$client->id}");

    $response->assertStatus(200);

    $this->assertDatabaseMissing('clients', ['id' => $client->id]);
});

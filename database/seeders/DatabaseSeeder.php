<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create();
        $clients = Client::factory()->count(3)->create(['user_id' => $user->id, 'reminder_method' => 'email']);

        foreach ($clients as $client) {
            for ($i = 0; $i < 4; $i++) {
                Appointment::factory()
                    ->withRandomDateForTimezone($client->timezone)
                    ->create([
                        'client_id' => $client->id,
                    ]);
            }
        }
    }
}

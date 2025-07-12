<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'client_id' => null, // will be overridden
            'title' => 'asd', // Random title with 3 words
            'status' => $this->faker->randomElement(['scheduled', 'completed', 'cancelled']), // Random status
            'date_time' => now(), // will be overridden
        ];
    }

    public function withRandomDateForTimezone(string $timezone): self
    {
        return $this->state(function () use ($timezone) {
            $isFuture = $this->faker->boolean;
            $days = $this->faker->numberBetween(1, 30);
            $hour = $this->faker->numberBetween(9, 16);
            $minute = $this->faker->numberBetween(0, 59);

            $local = $isFuture
                ? now($timezone)->addDays($days)
                : now($timezone)->subDays($days);

            return [
                'date_time' => $local->setTime($hour, $minute)->timezone('UTC')->toDateTimeString(),
            ];
        });
    }
}

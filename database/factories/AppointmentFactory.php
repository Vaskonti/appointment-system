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
            'title' => $this->faker->sentence,
            'date_time' => now(), // will be overridden
            'reminder_offset_minutes' => $this->faker->boolean ? $this->faker->numberBetween(5, 120) : null,
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

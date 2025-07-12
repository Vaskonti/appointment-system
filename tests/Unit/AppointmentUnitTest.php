<?php

use App\Constants\AppointmentStatus;

it('can get all appointment statuses', function () {
    $statuses = AppointmentStatus::cases();
    $statuses = array_map(fn($status) => $status->value, $statuses);
    expect($statuses)
        ->toHaveCount(4)
        ->toContain('scheduled', 'completed', 'cancelled', 'missed');
});

it('can get appointment status by value', function () {
    $status = AppointmentStatus::from('scheduled');
    expect($status)->toBeInstanceOf(AppointmentStatus::class);
    expect($status->value)->toBe('scheduled');
});

it('can cast appointment status to string', function () {
    $appointment = new \App\Models\Appointment([
        'status' => AppointmentStatus::SCHEDULED->value,
    ]);
    expect($appointment->status)->toBeInstanceOf(App\Constants\AppointmentStatus::class)
        ->and($appointment->status->value)->toBe('scheduled');
});

it('can cast appointment date_time to Carbon', function () {
    $appointment = new \App\Models\Appointment([
        'date_time' => '2025-10-01 10:00:00',
    ]);

    expect($appointment->date_time)->toBeInstanceOf(\Carbon\Carbon::class);
});

<?php

it('can get all appointment statuses', function () {
    $statuses = \App\Constants\AppointmentStatus::getAll();
    expect($statuses)->toBeArray()
        ->toHaveCount(4)
        ->toContain('scheduled', 'completed', 'cancelled', 'missed');
});

it('can get appointment status keys', function () {
    $keys = \App\Constants\AppointmentStatus::getKeys();
    expect($keys)->toBeArray()
        ->toHaveCount(4)
        ->toContain('SCHEDULED', 'COMPLETED', 'CANCELLED', 'MISSED');
});

it('can get appointment statuses as array', function () {
    $statusesArray = \App\Constants\AppointmentStatus::asArray();
    expect($statusesArray)->toBeArray()
        ->toHaveCount(4)
        ->toBe([
            'SCHEDULED' => 'scheduled',
            'COMPLETED' => 'completed',
            'CANCELLED' => 'cancelled',
            'MISSED' => 'missed'
        ]);
});

it('can get appointment status constants', function () {
    $constants = \App\Constants\AppointmentStatus::asArray();
    expect($constants)->toBeArray()
        ->toHaveCount(4)
        ->toHaveKey('SCHEDULED')
        ->toHaveKey('COMPLETED')
        ->toHaveKey('CANCELLED')
        ->toHaveKey('MISSED');
});

it('can check if appointment status constants are defined', function () {
    $constants = \App\Constants\AppointmentStatus::asArray();
    expect($constants)->toHaveKey('SCHEDULED')
        ->and($constants)->toHaveKey('COMPLETED')
        ->and($constants)->toHaveKey('CANCELLED')
        ->and($constants)->toHaveKey('MISSED');
});

it('can check if appointment status constants are not defined', function () {
    $constants = \App\Constants\AppointmentStatus::asArray();
    expect($constants)->not->toHaveKey('PENDING')
        ->and($constants)->not->toHaveKey('CONFIRMED');
});

it('can check if appointment status constant values are defined', function () {
    $constants = \App\Constants\AppointmentStatus::getAll();
    expect($constants)->toContain('scheduled')
        ->and($constants)->toContain('completed')
        ->and($constants)->toContain('cancelled')
        ->and($constants)->toContain('missed');
});

it('can check if appointment status constant values are not defined', function () {
    $constants = \App\Constants\AppointmentStatus::getAll();
    expect($constants)->not->toContain('pending')
        ->and($constants)->not->toContain('confirmed');
});

it('can get appointment status constant by key', function () {
    $status = \App\Constants\AppointmentStatus::asArray()['SCHEDULED'];
    expect($status)->toBe('scheduled');

    $status = \App\Constants\AppointmentStatus::asArray()['COMPLETED'];
    expect($status)->toBe('completed');

    $status = \App\Constants\AppointmentStatus::asArray()['CANCELLED'];
    expect($status)->toBe('cancelled');

    $status = \App\Constants\AppointmentStatus::asArray()['MISSED'];
    expect($status)->toBe('missed');
});


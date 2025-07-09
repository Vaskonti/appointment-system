<?php

namespace App\Repositories\Appointment;

use App\Models\Appointment;

interface AppointmentRepositoryInterface
{
    public function create(array $data): Appointment;
    public function findById(int $id): ?Appointment;
    public function update(int $id, array $data): Appointment;
    public function delete(int $id): bool;
    public function getAll(): array;

    public function getAppointmentsByUserId(int $userId): array;
}
<?php

namespace App\Services\Appointment;

use App\Models\Appointment;

interface AppointmentServiceInterface
{
    public function create(array $data): Appointment;
    public function findById(int $id);
    public function update(int $id, array $data): Appointment;
    public function delete(int $id): bool;
    public function getAll(): array;

    public function getPastAppointmentsByUserId(int $userId, int $clientId): array;
    public function getUpcomingAppointmentsByUserId(int $userId, int $clientId): array;
    public function updateStatus(int $id, string $status): Appointment;
}

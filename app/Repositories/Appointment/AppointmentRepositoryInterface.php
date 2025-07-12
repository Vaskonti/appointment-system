<?php

namespace App\Repositories\Appointment;

use App\Models\Appointment;
use Exception;

interface AppointmentRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function create(array $data): Appointment;
    public function findById(int $id): ?Appointment;
    public function update(int $id, array $data): Appointment;
    public function delete(int $id): bool;
    public function getAll(): array;

    public function getAppointmentsByUserId(int $userId): array;
    public function getPastAppointmentsByUserId(int $userId, int $clientId): array;
    public function getUpcomingAppointmentsByUserId(int $userId, int $clientId): array;
    public function updateStatus(int $id, string $status): Appointment;
}

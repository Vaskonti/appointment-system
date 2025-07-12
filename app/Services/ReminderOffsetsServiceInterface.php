<?php

namespace App\Services;

interface ReminderOffsetsServiceInterface
{
    public function create(int $appointmentId, array $data): void;

    public function findById(int $id): ?array;

    public function update(int $id, array $data): void;

    public function delete(int $id): bool;

    public function getAll(): array;

    public function getRemindersByAppointmentId(int $appointmentId): array;
    public function getRemindersByClientId(int $clientId): array;

    public function getRemindersByUserId(int $userId): array;

    public function getPastRemindersByUserId(int $userId): array;

    public function getUpcomingRemindersByUserId(int $userId): array;
}

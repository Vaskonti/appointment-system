<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Services\Appointment\AppointmentServiceInterface;

class AppointmentService implements AppointmentServiceInterface
{
    public function __construct(private readonly AppointmentRepositoryInterface $appointmentRepository)
    {
    }
    public function create(array $data): Appointment
    {
        return $this->appointmentRepository->create($data);
    }

    public function findById(int $id): ?Appointment
    {
        return $this->appointmentRepository->findById($id);
    }

    public function update(int $id, array $data): Appointment
    {
        return $this->appointmentRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->appointmentRepository->delete($id);
    }

    public function getAll(): array
    {
        return $this->appointmentRepository->getAll();
    }

    public function getAppointmentsByUserId(int $userId): array
    {
        return $this->appointmentRepository->getAppointmentsByUserId($userId);
    }

    public function getPastAppointmentsByUserId(int $userId, int $clientId): array
    {
        return $this->appointmentRepository->getPastAppointmentsByUserId($userId, $clientId);
    }

    public function getUpcomingAppointmentsByUserId(int $userId, int $clientId): array
    {
        return $this->appointmentRepository->getUpcomingAppointmentsByUserId($userId, $clientId);
    }

    public function updateStatus(int $id, string $status): Appointment
    {
        return $this->appointmentRepository->updateStatus($id, $status);
    }
}

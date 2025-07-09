<?php

namespace App\Services\Appointment;

use App\Models\Appointment;
use App\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Services\Appointment\AppointmentServiceInterface;

class AppointmentService implements AppointmentServiceInterface
{
    public function __construct(private readonly AppointmentRepositoryInterface $appointmentRepository) {}

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
}
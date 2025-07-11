<?php

namespace App\Services\Appointment;

use App\Models\Appointment;

interface AppointmentServiceInterface
{
    /**
     * Create a new appointment.
     *
     * @param array $data
     * @return Appointment
     */
    public function create(array $data): Appointment;

    /**
     * Find an appointment by its ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function findById(int $id);

    /**
     * Update an existing appointment.
     *
     * @param int $id
     * @param array $data
     * @return Appointment
     */
    public function update(int $id, array $data): Appointment;

    /**
     * Delete an appointment by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get all appointments.
     *
     * @return array
     */
    public function getAll(): array;

    public function getPastAppointmentsByUserId(int $userId, int $clientId): array;
    public function getUpcomingAppointmentsByUserId(int $userId, int $clientId): array;
}

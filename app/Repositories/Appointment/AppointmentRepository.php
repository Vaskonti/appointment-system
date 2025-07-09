<?php

namespace App\Repositories\Appointment;

use App\Models\Appointment;
use App\Models\Client;
use Exception;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    public function findById(int $id): ?Appointment
    {
        return Appointment::find($id);
    }

    /**
     * @throws Exception
     */
    public function update(int $id, array $data): Appointment
    {
        $appointment = $this->findById($id);
        if ($appointment) {
            $appointment->update($data);
            return $appointment;
        }
        throw new Exception("Appointment not found");
    }

    public function delete(int $id): bool
    {
        return Appointment::destroy($id) > 0;
    }

    public function getAll(): array
    {
        return Appointment::all()->toArray();
    }

    public function getAppointmentsByUserId(int $userId): array
    {
        return Client::where('user_id', $userId)
            ->with('appointments')
            ->get()
            ->toArray();
    }
}
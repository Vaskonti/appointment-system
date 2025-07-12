<?php

namespace App\Repositories\Appointment;

use App\Constants\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Client;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AppointmentRepository implements AppointmentRepositoryInterface
{
    /**
     * @throws Exception
     */
    public function create(array $data): Appointment
    {
        $start = Carbon::parse($data['date_time']);
        $end = $start->copy()->addMinutes($data['length_minutes']);

        $existingAppointment = Appointment::whereHas('client', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->where(function ($query) use ($start, $end) {
                $query->where('date_time', '<', $end)
                    ->whereRaw('DATE_ADD(date_time, INTERVAL length_minutes MINUTE) > ?', [$start]);
            })
            ->exists();
        if ($existingAppointment) {
            throw new Exception("An appointment already exists for this client at the specified time.");
        }
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

    public function getPastAppointmentsByUserId(int $userId, int $clientId): array
    {
        return Appointment::where('client_id', $clientId)
            ->with('reminderOffsets')
            ->where('date_time', '<', now())
            ->whereHas('client', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->toArray();
    }

    public function getUpcomingAppointmentsByUserId(int $userId, int $clientId): array
    {
        return Appointment::where('client_id', $clientId)
            ->with('reminderOffsets')
            ->where('date_time', '>=', now())
            ->whereHas('client', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get()
            ->toArray();
    }

    /**
     * @throws Exception
     */
    public function updateStatus(int $id, string $status): Appointment
    {
        $appointment = $this->findById($id);
        if ($appointment) {
            if (!in_array($status, AppointmentStatus::all())) {
                throw new Exception("Invalid status provided");
            }
            $appointment->status = $status;
            $appointment->save();
            return $appointment;
        }
        throw new Exception("Appointment not found");
    }
}

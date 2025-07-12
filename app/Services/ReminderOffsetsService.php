<?php

namespace App\Services;

use App\Models\ReminderOffsets;

class ReminderOffsetsService implements ReminderOffsetsServiceInterface
{

    public function create(int $appointmentId, array $data): void
    {
        foreach ($data as $reminderData) {
            ReminderOffsets::create(array_merge(['appointment_id' => $appointmentId], $reminderData));
        }
    }

    public function findById(int $id): ?array
    {
        return ReminderOffsets::findOrFail($id)->toArray();
    }

    public function update(int $id, array $data): void
    {
        $reminder = ReminderOffsets::findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return ReminderOffsets::destroy($id) > 0;
    }

    public function getAll(): array
    {
        return ReminderOffsets::all()->toArray();
    }

    public function getRemindersByAppointmentId(int $appointmentId): array
    {
        return ReminderOffsets::where('appointment_id', $appointmentId)->get()->toArray();
    }

    public function getRemindersByClientId(int $clientId): array
    {
        return ReminderOffsets::whereHas('appointment', function ($query) use ($clientId) {
            $query->where('client_id', $clientId);
        })->get()->toArray();
    }

    public function getRemindersByUserId(int $userId): array
    {
        return ReminderOffsets::whereHas('appointment', function ($query) use ($userId) {
            $query->whereHas('client', function ($clientQuery) use ($userId) {
                $clientQuery->where('user_id', $userId);
            });
        })->get()->toArray();
    }

    public function getPastRemindersByUserId(int $userId): array
    {
        return ReminderOffsets::whereHas('appointment', function ($query) use ($userId) {
            $query->whereHas('client', function ($clientQuery) use ($userId) {
                $clientQuery->where('user_id', $userId);
            })->where('date_time', '<', now());
        })->get()->toArray();
    }

    public function getUpcomingRemindersByUserId(int $userId): array
    {
        return ReminderOffsets::whereHas('appointment', function ($query) use ($userId) {
            $query->whereHas('client', function ($clientQuery) use ($userId) {
                $clientQuery->where('user_id', $userId);
            })->where('date_time', '>=', now());
        })->get()->toArray();
    }
}

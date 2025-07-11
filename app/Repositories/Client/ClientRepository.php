<?php

namespace App\Repositories\Client;

use App\Models\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ClientRepository implements ClientRepositoryInterface
{
    public function assignClientToUser(int $userId, int $clientId): bool
    {
        return Client::findOrFail($clientId)->update(['user_id' => $userId]);
    }

    public function getClientById(int $clientId): ?array
    {
        return Client::find($clientId)?->toArray() ?? null;
    }

    public function getClientsByUserId(int $userId): Collection
    {
        return Client::where('user_id', $userId)->get();
    }

    public function createClient(array $data): array
    {
        return Client::create(
            array_merge($data, ['user_id' => Auth::id()])
        )->toArray();
    }

    public function updateClient(int $clientId, array $data): bool
    {
        return Client::findOrFail($clientId)->update($data);
    }

    public function deleteClient(int $clientId): bool
    {
        return Client::destroy($clientId) > 0;
    }

    public function getClientAppointments(int $clientId): array
    {
        return Client::findOrFail($clientId)
            ->appointments()
            ->get()
            ->toArray() ?? [];
    }

    public function getClientByEmail(string $email): ?array
    {
        return CLient::where('email', $email)->first()?->toArray() ?? null;
    }

    public function getClientByPhone(string $phone): ?array
    {
       return Client::where('phone', $phone)->first()?->toArray() ?? null;
    }

    public function getClientByName(string $name): ?array
    {
        return Client::where('name', 'like', '%' . $name . '%')->first()?->toArray() ?? null;
    }
}

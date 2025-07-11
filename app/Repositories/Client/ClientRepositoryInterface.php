<?php

namespace App\Repositories\Client;

use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function assignClientToUser(int $userId, int $clientId): bool;
    public function getClientById(int $clientId): ?array;
    public function getClientsByUserId(int $userId): Collection;
    public function createClient(array $data): array;
    public function updateClient(int $clientId, array $data): bool;
    public function deleteClient(int $clientId): bool;
    public function getClientAppointments(int $clientId): array;
    public function getClientByEmail(string $email): ?array;
    public function getClientByPhone(string $phone): ?array;
    public function getClientByName(string $name): ?array;
}

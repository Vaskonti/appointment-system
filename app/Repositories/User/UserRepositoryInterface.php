<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function findByEmail(string $email): ?User;

    public function update(int $id, array $data): User;

    public function delete(int $id): bool;

    public function getAll(): array;
}

<?php

namespace App\Services\User;

use App\Models\User;

interface UserServiceInterface
{
    public function registerUser(string $name, string $email, string $password): ?User;
    public function checkUserExists(string $email): bool;
    public function validatePassword(string $email, string $password): bool;
    public function getUserByEmail(string $email): ?User;
    public function updateUser(int $id, array $data): User;
    public function deleteUser(int $id): bool;
    public function getAllUsers(): array;
}

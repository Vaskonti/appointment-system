<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function registerUser(string $name, string $email, string $password): ?User
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ];

        return $this->userRepository->create($data);
    }

    public function checkUserExists(string $email): bool
    {
        return $this->userRepository->findByEmail($email) !== null;
    }

    public function validatePassword(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return false;
        }
        return Hash::check($password, $user->password);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    public function updateUser(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }
}

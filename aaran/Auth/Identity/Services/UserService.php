<?php

namespace Aaran\Auth\Identity\Services;

use Aaran\Auth\Identity\Repositories\UserRepository;
use Aaran\Auth\Identity\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class UserService
{
    public function __construct(protected UserRepository $userRepository) {}

    public function getAllUsers(): iterable
    {
        return $this->userRepository->all();
    }

    public function getUserById(string $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function registerUser(array $data): User
    {
        return $this->userRepository->create($data);
    }

    public function updateUser(string $id, array $data): User
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            Log::warning("Update failed: User with ID {$id} not found.");
            throw new Exception("User not found");
        }

        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(string $id): bool
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            Log::error("Delete failed: User with ID {$id} not found.");
            throw new Exception("User not found");
        }

        $deleted = $this->userRepository->delete($user);

        if ($deleted) {
            Log::info("User with ID {$id} deleted successfully.");
        } else {
            Log::error("Failed to delete user with ID {$id}.");
        }

        return $deleted;
    }

    public function authenticate(array $credentials, bool $remember = false): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            return true;
        }

        return false;
    }
}

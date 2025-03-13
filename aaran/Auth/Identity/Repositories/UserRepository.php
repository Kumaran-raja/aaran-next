<?php

namespace Aaran\Auth\Identity\Repositories;

use Aaran\Auth\Identity\Models\User;

class UserRepository
{
    public function all()
    {
        return User::all();
    }

    public function findById(int $id): ?User
    {
        return User::findOrFail($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}

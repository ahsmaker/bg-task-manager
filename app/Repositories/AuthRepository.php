<?php

namespace App\Repositories;

use App\Collections\AuthResultCollection;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    public function createNewUser(array $data): ?User
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getUpdatedUserTokenData(User $user): AuthResultCollection
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        return new AuthResultCollection([
            'token_type'   => 'Bearer',
            'access_token' => $token,
        ]);
    }
}


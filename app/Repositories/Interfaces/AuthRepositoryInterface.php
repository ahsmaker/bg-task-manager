<?php

namespace App\Repositories\Interfaces;

use App\Collections\AuthResultCollection;
use App\Models\User;

interface AuthRepositoryInterface
{
    public function createNewUser(array $data): ?User;
    public function findUserByEmail(string $email): ?User;
    public function getUpdatedUserTokenData(User $user): AuthResultCollection;

}
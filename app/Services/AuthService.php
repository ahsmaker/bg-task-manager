<?php

namespace App\Services;

use App\Collections\AuthResultCollection;
use App\Exceptions\InvalidCredentialsException;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data): AuthResultCollection
    {
        $user = $this->authRepository->createNewUser($data);

        return $this->authRepository->getUpdatedUserTokenData($user);
    }

    /**
     * @throws InvalidCredentialsException
     */
    public function login(array $data): AuthResultCollection
    {
        $user = $this->authRepository->findUserByEmail($data['email']);

        if(!$user || !Hash::check($data['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }

        return $this->authRepository->getUpdatedUserTokenData($user);
    }

}

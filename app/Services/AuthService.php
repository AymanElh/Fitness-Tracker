<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $user = $this->userRepository->create($data);
//        event(new Registred($user));

        Auth::login($user);
        return $user;
    }

    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        Auth::login($user);
        return $user;
    }

        public function logout() : bool
        {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            return true;
        }
}

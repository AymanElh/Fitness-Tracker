<?php

namespace App\Services;

use App\Mail\ResetPassword;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

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

    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data)
    {
        $user = $this->userRepository->create($data);
//        event(new Registred($user));

        Auth::login($user);
        return $user;
    }

    /**
     * @param array $credentials
     * @return false|mixed
     */
    public function login(array $credentials)
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if(!$user || !Hash::check($credentials['password'], $user->password)) {
            return false;
        }

        Auth::login($user);
        return $user;
    }

    /**
     * @return bool
     */
    public function logout(): bool
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return true;
    }

    /**
     * @param string $email
     * @return false|void
     */
    public function sendPasswordResetLink(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if(!$user) {
            return false;
        }

        $token = Password::createToken($user);
//        dd($token);
        $this->userRepository->createPasswordReset($email, $token);
        Mail::to($email)->send(new ResetPassword($token, $user->name));
        return $token;
    }

    public function resetPassword(array $data) : bool
    {
        $reset = $this->userRepository->findPasswordReset($data['email']);
        if(!$reset || $reset->token !== $data['token']) {
            return false;
        }

        $user = $this->userRepository->findByEmail($data['email']);

        if(!$user) {
            return false;
        }

        $this->userRepository->update($user->id, ['password' =>  $data['password']]);
        $this->userRepository->deletePasswordReset($data['email']);

        return true;
    }
}

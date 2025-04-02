<?php

namespace App\Repositories;

use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new User
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);
    }

    /**
     * Find a user by its id
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        return User::find($id);
    }

    /**
     * Find a user by their email address
     *
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param int $id
     * @param array $data
     * @return null
     */
    public function update(int $id, array $data)
    {
        $user = $this->findById($id);
        if($user) {
            $user->update($data);
            return $user->fresh();
        }
        return null;
    }

    public function createPasswordReset(string $email, string $token)
    {
        return PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
    }

    public function findPasswordReset(string $email)
    {
        return PasswordReset::where('email', $email)->where('created_at', '>=', Carbon::now()->subHour())->first();
    }

    public function deletePasswordReset(string $email)
    {
        return PasswordReset::where('email', $email)->delete();
    }
}

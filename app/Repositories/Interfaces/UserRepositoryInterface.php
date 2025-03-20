<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function findById(int $id);
    public function findByEmail(string $email);
    public function update(int $id, array $data);
    public function createPasswordReset(string $email, string $token);
    public function findPasswordReset(string $email);
    public function deletePasswordReset(string $email);
}

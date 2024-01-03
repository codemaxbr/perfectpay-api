<?php

namespace App\Repositories;

use App\Interfaces\UserService;
use App\Models\User;
use App\Repositories\Repository;
use Exception;

class UserRepository extends Repository implements UserService
{
    /**
     * Definição do model
     */
    public function model(): string
    {
        return User::class;
    }

    public function login(array $credentials): User
    {
        try {
            /** @var User $user */
            $user = $this->model->where('email', $credentials['email'])->first();

            if (!$user) {
                throw new Exception('Usuário não encontrado');
            }

            if (!password_verify($credentials['password'], $user->password)) {
                throw new Exception('Senha incorreta');
            }

            return $user;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Services\UserService;
use App\Models\User;
use App\Repositories\Repository;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository extends Repository implements UserService
{
    /**
     * Definição do model
     */
    public function model(): string
    {
        return User::class;
    }

    public function login(array $credentials, $scope = 'users'): User
    {
        try {
            /** @var User $user */
            $user = $this->model
                ->where([
                    'email' => $credentials['email'],
                    'scope' => $scope
                ])
                ->first();

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

    public function register(array $data, $scope = 'users'): User
    {
        try {
            DB::beginTransaction();
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            /** @var User $user */
            $user = $this->model->create($data);

            if ($scope == 'customers') {
                /** @var Customer $customer */
                $customer = $user->customer()->create($data);
                $user->customer_id = $customer->id;
                $user->save();

                event(new \App\Events\CustomerCreated($customer));
            }

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}

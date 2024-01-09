<?php

namespace App\Services;

interface UserService extends Service
{
    public function login(array $credentials, $scope);
    public function register(array $data, $scope);
}

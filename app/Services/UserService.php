<?php

namespace App\Services;

interface UserService extends Service
{
    public function login(array $credentials);
    public function register(array $data);
}

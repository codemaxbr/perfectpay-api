<?php

namespace App\Interfaces;

interface UserService extends RepositoryInterface
{
    public function login(array $credentials);
}

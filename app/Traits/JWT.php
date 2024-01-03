<?php

namespace App\Traits;

use Firebase\JWT\Key;

trait JWT
{
    public function generateToken()
    {
        $payload = [
            'iss' => "user", // Issuer of the token
            'sub' => $this->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 * 24 * 7 // Expiration time
        ];

        return \Firebase\JWT\JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}

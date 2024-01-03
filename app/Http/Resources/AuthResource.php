<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'status' => true,
            'token' => $this->generateToken(),
            'user' => [
                'name' => $this->name,
                'email' => $this->email
            ]
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'cpf_cnpj',
        'external_id'
    ];

    public function address()
    {
        return $this->hasOne(CustomersAddress::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}

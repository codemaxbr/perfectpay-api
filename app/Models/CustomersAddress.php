<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomersAddress extends Model
{
    protected $fillable = [
        'customer_id',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zipcode',
        'country',
    ];

    protected $hidden = [
        'id',
        'customer_id',
        'created_at',
        'updated_at',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

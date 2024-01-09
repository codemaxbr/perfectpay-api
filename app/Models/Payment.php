<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_method',
        'amount',
        'external_id',
        'order_id',
        'status',
        'json'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

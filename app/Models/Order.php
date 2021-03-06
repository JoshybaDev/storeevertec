<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'codebuy',
        'customer_name',
        'customer_surname',
        'customer_email',
        'customer_mobile',
        'cant',
        'total',
        'user_address_id'
    ];
}

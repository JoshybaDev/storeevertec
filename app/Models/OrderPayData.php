<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayData extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'process_url',
        'request_id',
        'menssage_error',
        'status_pay',
        'status_mesage',
        'status_date'
    ];     
}

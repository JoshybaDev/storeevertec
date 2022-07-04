<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'package_id',
        'coust',
        'responseapi'
    ];      
}

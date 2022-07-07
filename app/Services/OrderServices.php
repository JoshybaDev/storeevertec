<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderPackage;

class OrderServices
{
    public static function saveOrderStatusSended($order_id,$tracking_number): void
    {
        OrderPackage::where('order_id','=',$order_id)
        ->update([
            'tracking_number'=>$tracking_number
        ]);
        Order::where('id','=',$order_id)
        ->update([
            'status'=>'SENDED'
        ]);
    }
}
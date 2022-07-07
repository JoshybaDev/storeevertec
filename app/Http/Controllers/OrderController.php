<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Services\UserServices;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show list order all
     *
     * @return void
     */
    public function index()
    {
        $orders = Order::paginate(10);
        return view('order.list', compact('orders'));
    }
    /**
     * Show an order
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $orderId = $id;
        $order = Order::where('id', '=', $orderId)->get();
        $user = UserServices::currentUser();
        $items = OrderDetail::where('order_id', '=', $orderId)->get();
        return view('order.show', compact('items', 'user', 'order'));
    }
}

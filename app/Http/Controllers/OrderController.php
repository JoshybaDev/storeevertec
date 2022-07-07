<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderPackage;
use App\Models\OrderPayData;
use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Services\OrderServices;
use App\Http\Requests\OrderSendedRequest;
use App\Models\OrderAddress;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;

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
        $orderPay = OrderPayData::where('order_id', '=', $orderId)->get();
        $orderAddress = OrderAddress::where('order_id', '=', $orderId)->get();
        $orderPackage = OrderPackage::where('order_id', '=', $orderId)->get();
        return view('order.show', compact('items', 'user', 'order', 'orderPay','orderAddress','orderPackage'));
    }
    /**
     * Method return url of request pay 
     *
     * @param [type] $id
     * @return void
     */
    public function showUrlPay($id)
    {
        if (Auth()->user()->level != 'ADMIN') {
            return '';
        }
        $orderPay = OrderPayData::where('order_id', '=', $id)->select('proccess_url')->get();
        return '
        <iframe id="inlineFrameExample" title="Show data pay" width="450px" height="600px"
        style="border:none" src="' . $orderPay[0]['proccess_url'] . '">
        </iframe>        
        ';
    }
    public function ordersended(OrderSendedRequest $request)
    {
        if (Auth()->user()->level != 'ADMIN') {
            return redirect()->route('orders')->withErrors(['erros' => 'Not authorized']);
        }
        $order = Order::where('id', '=', $request->order_id)->get();
        if ($order[0]['status'] != 'PAYED') {
            return redirect()->route('orders.show', ['id' => $request->order_id])->withErrors(['erros' => 'Status Incorrect, Only status PAYED']);
        }
        OrderServices::saveOrderStatusSended($request->order_id,$request->tracking_number);
        return redirect()->route('orders.show', ['id' => $request->order_id])->with(['status' => 'Status updated successfully!']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressSaveRequest;
use App\Http\Requests\CheckoutCreateOrdenRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Services\CartServices;
use App\Services\CheckoutServices;
use App\Services\UserServices;

class CheckOutController extends Controller
{
    /**
     * Get data of checkout
     * Name route: checkout1
     *
     * @return void
     */
    public function index()
    {
        $user=UserServices::currentUser();
        $items = CartServices::cart_items();
        $total = CartServices::cart_mount_total();
        if(empty($items))
        {
            return redirect()->route('products');
        }
        return view('checkout.checkout',compact('items','total','user'));
    }
    /**
     * Create order
     * Name route: checkout2
     *
     * @return void
     */
    public function store(CheckoutCreateOrdenRequest $request)
    {
        $validated = $request->validated();
        $codeunique =CheckoutServices::create_order_with_items($request->all());
        return redirect()->route('checkout3',['codeunique'=>$codeunique]);
    }
    /**
     * Show form capture direction for anonymous
     * Name route: checkout3
     *
     * @return void
     */
    public function direction($codeunique)
    {
        if($codeunique=='NoValidCode_EmptyProducts'){
            return view('checkout.checkout_direction_error',compact('codeunique'));
        }
        $user=UserServices::currentUser();
        $list_address=[];
        $order=Order::where('codebuy','=',$codeunique)->get();
        $items=OrderDetail::where('order_id','=',$order[0]["id"])->get();
        CartServices::cartEmptyNow();
        $total=$order[0]["total"];
        return view('checkout.checkout_direction',compact('codeunique','items','total','list_address','user'));
    }
    /**
     * Save information of de order
     * if user is anonymous save only order
     * else save in user_addresses and order
     * Name route: checkout4
     *
     * @return void
     */
    public function storeDirection(AddressSaveRequest $request)
    {
        $validated = $request->validated();
        $user_id=UserServices::currentUser()["user_id"];
        if($user_id>0)
        {

        }
        else
        {
            CheckoutServices::SaveAddressAnonymus($request->all());
            return redirect()->route('checkout5',['codeunique'=>$request->codeunique]);
        }
    }
    /**
     * Proccess tu pay order
     * Name route: checkout5
     *
     * @return void
     */
    public function checkoutpay()
    {
        # code...
    }
}

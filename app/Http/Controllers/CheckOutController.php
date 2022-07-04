<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressSaveRequest;
use App\Http\Requests\CheckoutCreateOrdenRequest;
use App\Http\Requests\PackageSelectForShippingRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Package;
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
        $user = UserServices::currentUser();
        $items = CartServices::cartItems();
        $total = CartServices::cartMountTotal();
        if (empty($items)) {
            return redirect()->route('products');
        }
        return view('checkout.checkout', compact('items', 'total', 'user'));
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
        $codeunique = CheckoutServices::createOrderWithItems($request->all());
        CartServices::cartEmptyNow();
        return redirect()->route('checkout3', ['codeunique' => $codeunique]);
    }
    /**
     * for all method or all methods that require the uniquecode parameter
     *
     * @return void
     */
    public function invalidCode()
    {
        return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
    }
    /**
     * Show form capture direction for anonymous
     * Name route: checkout3
     *
     * @return void
     */
    public function direction($codeunique)
    {
        if ($codeunique == 'NoValidCode_EmptyProducts') {
            return view('checkout.address_error', compact('codeunique'));
        }
        $order = Order::where('codebuy', '=', $codeunique)->select('id', 'total')->get();
        if ($order->isEmpty()) {
            return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
        }
        if (!CheckoutServices::verifyCheckout3AddressEmpty($order[0]['id'])) {
            if (CheckoutServices::verifyCheckout3PackagesEmpty($order[0]['id'])) {
                return redirect()->route('checkout5', ['codeunique' => $codeunique]);
            }
            return redirect()->route('checkout7', ['codeunique' => $codeunique]);
        }

        $user = UserServices::currentUser();
        $listAddress = [];
        $items = OrderDetail::where('order_id', '=', $order[0]["id"])->get();
        $total = $order[0]["total"];
        return view('checkout.address', compact('codeunique', 'items', 'total', 'listAddress', 'user'));
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
        $user_id = UserServices::currentUser()["user_id"];
        if ($user_id > 0) {
        } else {
            CheckoutServices::saveAddressanonymous($request->all());
            return redirect()->route('checkout5', ['codeunique' => $request->codeunique]);
        }
    }
    /**
     * Undocumented function
     * Name route: checkout45
     *
     * @return void
     */
    public function selectDirection()
    {
        # code...
    }
    /**
     * List de packages
     * Name route: checkout5
     * Get
     *
     * @return void
     */
    public function shipping($codeunique)
    {
        $order = Order::where('codebuy', '=', $codeunique)->select('id', 'total')->get();
        if ($order->isEmpty()) {
            return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
        }
        if (CheckoutServices::verifyCheckout3AddressEmpty($order[0]['id'])) {
            return redirect()->route('checkout3', ['codeunique' => $codeunique]);
        } elseif (!CheckoutServices::verifyCheckout3PackagesEmpty($order[0]['id'])) {
            return redirect()->route('checkout7', ['codeunique' => $codeunique]);
        }
        $listPackages = Package::all();
        $user = UserServices::currentUser();
        $items = OrderDetail::where('order_id', '=', $order[0]["id"])->get();
        $total = $order[0]["total"];
        return view('checkout.shipping', compact('codeunique', 'items', 'total', 'listPackages', 'user'));
    }
    /**
     * Save select your package for shipping
     * Name route: checkout6
     * Post
     *
     * @return void
     */
    public function shippingSave(PackageSelectForShippingRequest $request)
    {
        $validated = $request->validated();
        $order = Order::where('codebuy', '=', $request->codeunique)->select('id', 'total')->get();
        if ($order->isEmpty()) {
            return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
        }
        CheckoutServices::savePackageforOrder($request->all(), $order);
        return redirect()->route('checkout7', ['codeunique' => $request->codeunique]);
    }
    /**
     * Proccess tu pay order
     * Name route: checkout7
     *
     * @return void
     */
    public function checkoutpay($codeunique)
    {
        $order = Order::where('codebuy', '=', $codeunique)->select('id', 'total')->get();
        if ($order->isEmpty()) {
            return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
        }
        if (CheckoutServices::verifyCheckout3AddressEmpty($order[0]['id'])) {
            return redirect()->route('checkout3', ['codeunique' => $codeunique]);
        }
        if (CheckoutServices::verifyCheckout3PackagesEmpty($order[0]['id'])) {
            return redirect()->route('checkout5', ['codeunique' => $codeunique]);
        }
    }
    /**
     * Main view of the order, 
     * if the status is payed, 
     * sended do not redirect, 
     * if you do not payed or rejected go to 7
     * else is created
     * if you do not have an address go to 3, 
     * if you do not have a package go to 5, 
     *
     * @param [type] $codeunique
     * @return void
     */
    public function show($codeunique)
    {
        $order = Order::where('codebuy', '=', $codeunique)->select('id', 'status')->get();
        if (empty($order[0])) {
            return redirect()->route('products')->withErrors(['codeunique' => 'Your Code is Invalid!!']);
        }
        $orderStatus = $order[0]['status'];
        $orderId = $order[0]['id'];
        switch ($orderStatus) {
            case 'PAYED':
                # code...
                break;
            case 'SENDED':
                break;
            case 'REJECTED':
            case 'CREATED':
                return CheckoutServices::verifyEmptiesOrder($orderId, $codeunique);
                break;
            default:
                # code...
                break;
        }
        dd($orderStatus, 'Joshyba');
    }
}

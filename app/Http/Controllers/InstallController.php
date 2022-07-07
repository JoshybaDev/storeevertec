<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Helpers\Helper;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Services\CheckoutServices;
use Illuminate\Support\Facades\Artisan;

class InstallController extends Controller
{
    /**
     * Install Demo Store
     *
     * @return void
     */
    public function index()
    {
        Artisan::call("migrate");
        //Artisan::call("migrate:refresh");
        //creates 5 products
        //creates 5 packages
        Artisan::call("db:seed");
        //creates al user anonymous
        Helper::create_user_anonymous();
        //creates the user admin
        return 'Install demo complete.';
    }
    public function emailshowtest($codeunique)
    {
        #verify view conent
        $dataEmail = [];
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $user = UserServices::currentUser();
        $items = OrderDetail::where('order_id', '=', $order[0]["id"])->get();
        $dataEmail = [
            'codeunique' => $codeunique,
            'user' => $user,
            'items' => $items,
            'order' => $order
        ];
        return view('mails.checkout', compact('dataEmail'));
    }
    public function sendEmailCheckOut($codeunique)
    {
        CheckoutServices::sendEmail($codeunique);
    }
}

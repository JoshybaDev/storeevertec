<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;
use App\Models\OrderAddress;
use App\Models\OrderPackage;
use App\Mail\MailOrderCheckout;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

final class CheckoutServices
{
    /**
     * Create order with data cliente
     *
     * @param [array] $dataClient
     * @return void
     */
    public static function createOrderWithItems(array $dataClient): string
    {
        $codigoUnique = self::getNotExistsCodebuyInOrder();
        $items = CartServices::cartItems();
        if (empty($items)) {
            return 'NoValidCode_EmptyProducts';
        }
        $total = CartServices::cartMountTotal();
        $products_total = CartServices::cartProductsTotal();
        $id = self::createOrder($codigoUnique, $dataClient, $products_total, $total);
        self::createOrderDetails($id, $items);
        return Order::find($id)->codebuy;
    }
    /**
     * Function recursive while codebuy is not unique
     *
     * @return string
     */
    public static function getNotExistsCodebuyInOrder(): string
    {
        $codigoUnique = Str::random(20);
        if (self::verifyCodebuyNotExistsInAnOrder($codigoUnique)) {
            return $codigoUnique;
        } else {
            self::getNotExistsCodebuyInOrder();
        }
    }
    /**
     * Verify if codebuy no exists in order
     *
     * @param [string] $codigoUnique
     * @return bool
     */
    public static function verifyCodebuyNotExistsInAnOrder($codigoUnique): bool
    {
        $order = Order::where('codebuy', '=', $codigoUnique)->select('id')->get();
        return $order->isEmpty();
    }
    /**
     * Create order
     *
     * @param string $codigoUnique
     * @param array $dataClient
     * @param float $products_total
     * @param float $total
     * @return integer order_id
     */
    private static function createOrder(string $codigoUnique, array $dataClient, float $products_total, float $total): int
    {
        return Order::create([
            'user_id' => $dataClient["user_id"],
            'codebuy' => $codigoUnique,
            'customer_name' => $dataClient["user_name"],
            'customer_surname' => $dataClient["user_surname"],
            'customer_email' => $dataClient["user_email"],
            'customer_mobile' => $dataClient["user_mobile"],
            'cant' => $products_total,
            'total' => $total,
            'user_address_id' => 0
        ])->id;
    }
    /**
     * Create order details
     *
     * @param integer $id
     * @param array $items
     * @return void
     */
    private static function createOrderDetails(int $id, array $items): void
    {
        foreach ($items as $key => $item) {
            OrderDetail::create([
                'order_id' => $id,
                'product_id' => $item['product_id'],
                'price' => $item['product_price'],
                'cant' => $item['product_cant'],
                'subtotal' => $item['product_subtotal'],
                'name' => $item['product_name'],
                'vigency' => Carbon::now()->addDays(2),
            ]);
        }
    }
    public static function saveAddresUser(array $DataAddress): void
    {
        $order_id = Order::where('codebuy', '=', $DataAddress['codeunique'])
            ->select('id')
            ->get()[0]['id'];
        $userAddresIs = UserAddress::create([
            'user_id' => Auth()->user()->id,
            'street' => $DataAddress['street'],
            'city' => $DataAddress['city'],
            'state' => $DataAddress['state'],
            'zipcode' => $DataAddress['zipcode'],
        ]);
        OrderAddress::create([
            'order_id' => $order_id,
            'street' => $DataAddress['street'],
            'city' => $DataAddress['city'],
            'state' => $DataAddress['state'],
            'zipcode' => $DataAddress['zipcode'],
        ]);
        $order_id = Order::where('codebuy', '=', $DataAddress['codeunique'])
            ->update([
                'user_address_id' => $userAddresIs->id,
            ]);
    }
    /**
     * Save address your user anonymous
     *
     * @param array $DataAddress
     * @return void
     */
    public static function saveAddressanonymous(array $DataAddress): void
    {
        $order_id = Order::where('codebuy', '=', $DataAddress['codeunique'])
            ->select('id')
            ->get()[0]['id'];
        OrderAddress::create([
            'order_id' => $order_id,
            'street' => $DataAddress['street'],
            'city' => $DataAddress['city'],
            'state' => $DataAddress['state'],
            'zipcode' => $DataAddress['zipcode'],
        ]);
    }
    /**
     * Full verify empty feature order
     *
     * @param integer $orderId
     * @param string $orderStatus
     * @param string $codeunique
     * @return void
     */
    public static function verifyEmptiesOrder(int $orderId, string $codeunique)
    {
        if (self::verifyCheckout3AddressEmpty($orderId)) {
            return redirect()->route('checkout3', ['codeunique' => $codeunique]);
        }
        if (self::verifyCheckout3PackagesEmpty($orderId)) {
            return redirect()->route('checkout5', ['codeunique' => $codeunique]);
        }
        return redirect()->route('checkout7', ['codeunique' => $codeunique]);
    }
    /**
     * Verify if Packages of order is empty
     *
     * @param [type] $orderId
     * @return boolean
     */
    public static function verifyCheckout3PackagesEmpty($orderId): bool
    {
        $orderPackagesId = OrderPackage::where('order_id', '=', $orderId)->get();
        if ($orderPackagesId->isEmpty()) {
            return true;
        }
        return false;
    }
    /**
     * Verify if Address of order is empty
     *
     * @param integer $orderId
     * @return boolean
     */
    public static function verifyCheckout3AddressEmpty(int $orderId): bool
    {
        $orderDeatilsId = OrderAddress::where('order_id', '=', $orderId)->select('id')->get();
        if ($orderDeatilsId->isEmpty()) {
            return true;
        }
        return false;
    }
    /**
     * Save package for order
     *
     * @param array $paramsPackages
     * @param Collection $order
     * @return void
     */
    public static function savePackageforOrder(array $paramsPackages, Collection $order)
    {
        OrderPackage::create([
            'order_id' => $order[0]->id,
            'package_id' => $paramsPackages['package_id'],
            'coust' => 0.00,
            'responseapi' => ''
        ]);
    }
    /**
     * Send email with data order
     *
     * @param [string] $codeunique
     * @return void
     */
    public static function sendEmail($codeunique)
    {
        $dataEmail = [];
        $order = Order::where('codebuy', '=', $codeunique)->get();
        if (!$order->isEmpty()) {
            $items = OrderDetail::where('order_id', '=', $order[0]["id"])->get();
            $total = $order[0]["total"];
            $dataEmail = [
                'codeunique' => $codeunique,
                'order' => $order,
                'items' => $items,
                'total' => $total
            ];
            $dataEmail[0] = 'Joshyba';
            Mail::to($order[0]->customer_email)->send(new MailOrderCheckout($dataEmail,));
        }
    }
}

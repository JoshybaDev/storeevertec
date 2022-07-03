<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Str;

final class CheckoutServices
{
    /**
     * Create order with data cliente
     *
     * @param [array] $dataClient
     * @return void
     */
    public static function create_order_with_items(array $dataClient): string
    {
        $codigoUnique = self::get_not_exists_codebuy_in_order();
        $items = CartServices::cart_items();
        if (empty($items)) {
            return 'NoValidCode_EmptyProducts';
        }
        $total = CartServices::cart_mount_total();
        $products_total = CartServices::cart_products_total();
        $id = self::create_order($codigoUnique, $dataClient, $products_total, $total);
        self::create_order_details($id, $items);
        return Order::find($id)->codebuy;
    }
    /**
     * Function recursive while codebuy is not unique
     *
     * @return string
     */
    public static function get_not_exists_codebuy_in_order(): string
    {
        $codigoUnique = Str::random(20);
        if (self::verify_codebuy_not_exists_in_an_order($codigoUnique)) {
            return $codigoUnique;
        } else {
            self::get_not_exists_codebuy_in_order();
        }
    }
    /**
     * Verify if codebuy no exists in order
     *
     * @param [string] $codigoUnique
     * @return bool
     */
    public static function verify_codebuy_not_exists_in_an_order($codigoUnique): bool
    {
        $order = Order::where('codebuy', '=', $codigoUnique)->get();
        //dd($order[0]['codebuy']);
        return empty($order[0]);
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
    private static function create_order(string $codigoUnique, array $dataClient, float $products_total, float $total): int
    {
        return Order::create([
            'user_id' => $dataClient["user_id"],
            'codebuy' => $codigoUnique,
            'customer_name' => $dataClient["user_name"],
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
    private static function create_order_details(int $id, array $items): void
    {
        foreach ($items as $key => $item) {
            OrderDetail::create([
                'order_id' => $id,
                'product_id' => $item['product_id'],
                'price' => $item['product_price'],
                'cant' => $item['product_cant'],
                'subtotal' => $item['product_subtotal'],
                'name' => $item['product_name'],
            ]);           
        }
    }
    public static function SaveAddressAnonymus(array $DataAddress)
    {

    }
}

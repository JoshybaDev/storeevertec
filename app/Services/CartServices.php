<?php

namespace App\Services;

use App\Models\Product;

final class CartServices
{
    /**
     * Verify in the session if exists cart-items
     *
     * @return array
     */
    public static function cartItems(): array
    {
        return session()->get('cart_items') ?? [];
    }
    /**
     * Verify in the session if exists cart-total
     *
     * @return integer
     */
    public static function cartMountTotal(): int
    {
        return session()->get('cart_total') ?? 0;
    }
    /**
     * Verify in the session if exists cart-total
     *
     * @return integer
     */
    public static function cartProductsTotal(): int
    {
        return session()->get('cart_products_total') ?? 0;
    }    
    /**
     * Update session with cart_items
     *
     * @param Product $product
     * @return void
     */
    public static function cartAddItems(Product $product)
    {
        $items = self::cartItems();
        $total = self::cartMountTotal();
        $productsTotal = self::cartProductsTotal();
        $item = [
            "product_id" => $product->id,
            "product_cant" => 1,
            "product_name" => $product->name,
            "product_price" => $product->price,
            "product_subtotal" => $product->price,
        ];
        array_push($items, $item);
        $total += $product->price * 1;
        $productsTotal += 1;
        session()->put('cart_items', $items);
        session()->put('cart_total', $total);
        session()->put('cart_products_total', $productsTotal);
    }
    /**
     * Delete from session the items and update total
     *
     * @param [int] $product_id
     * @return void
     */
    public static function cartDelItem(int $productId): void
    {
        $items = self::cartItems();
        $total = 0;
        $productsTotal =0;
        //dd($items,$product_id);
        foreach ($items as $key => $item) {
            if ($item["product_id"] == $productId) {
                unset($items[$key]);
                break;
            }
        }
        $items = array_values($items);
        foreach ($items as $key => $item) {
            $total += $item["product_price"];
            $productsTotal += 1;
        }
        session()->put('cart_items', $items);
        session()->put('cart_total', $total);
        session()->put('cart_products_total', $productsTotal);
    }
    /**
     * Empty cart
     *
     * @return void
     */
    public static function cartEmptyNow(): void
    {
        session()->put('cart_items', []);
        session()->put('cart_total', 0);
        session()->put('cart_products_total', 0);
    }
}

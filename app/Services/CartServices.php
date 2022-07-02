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
    public static function cart_items(): array
    {
        return session()->get('cart-items') ?? [];
    }
    /**
     * Verify in the session if exists cart-total
     *
     * @return integer
     */
    public static function cart_mount_total() : int
    {
        return session()->get('cart-total') ?? 0;
    }
    /**
     * Update session with cart_items
     *
     * @param Product $product
     * @return void
     */
    public static function cart_add_items(Product $product)
    {
        $items=self::cart_items();
        $total=self::cart_mount_total();
        $item=[
            "product_id"=>$product->id,
            "product_cant"=>1,
            "product_name"=>$product->name,             
            "product_price"=>$product->price,
            "product_subtotal"=>$product->price, 
        ];
        array_push($items,$item);
        $total+=$product->price*1;
        session()->put('cart-items',$items);
        session()->put('cart-total',$total);
    }
    /**
     * Delete from session the items and update total
     *
     * @param [type] $product_id
     * @return void
     */
    public static function cart_del_item(int $product_id) :void
    {
        $items=self::cart_items();
        $total=0;
        //dd($items,$product_id);
        foreach ($items as $key => $item) {
            if($item["product_id"]==$product_id)
            { 
                unset($items[$key]); 
                break;
            }
        }
        $items = array_values($items);
        foreach ($items as $key => $item) {
            $total+=$item["product_price"];
        }    
        session()->put('cart-items',$items);    
        session()->put('cart-total',$total);
    }
}

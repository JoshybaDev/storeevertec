<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddItemRequest;
use App\Http\Requests\CartDelItemRequest;
use App\Models\Product;
use App\Services\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the cart
     *
     * @return void
     */
    public function index()
    {
        $items = CartServices::cart_items();
        $total = CartServices::cart_mount_total();
        return view('cart.cart',compact('items','total'));
    }
    /**
     * Add item product of the cart
     *
     * @param CartAddItemRequest $request
     * @return void
     */
    public function cartAdd(CartAddItemRequest $request)
    {
        $validated = $request->validated();
        $product_id=$request->product_id;
        $product=Product::find($product_id);
        CartServices::cart_add_items($product);
        return redirect()->route('cart');
    }
    /**
     * Delete item producto of the cart
     *
     * @param CartDelItemRequest $request
     * @return void
     */
    public function cartDel(CartDelItemRequest $request)
    {
        $validated = $request->validated();
        $product_id=$request->product_id;
        CartServices::cart_del_item($product_id);
        return redirect()->route('cart');        
    }
}

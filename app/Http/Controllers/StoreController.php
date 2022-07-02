<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StoreController extends Controller
{
    /**
     * Display a listing of products in the store
     *
     * @return void
     */
    public function index()
    {
        $products = Product::all();
        return view('store.store',compact('products'));
    }
    /**
     * Display details of a product
     *
     * @param [int] $product_id
     * @return void
     */
    public function show($product_id)
    {
        $product=Product::find($product_id);
        if(!empty($product))
        {
            return view('store.show',compact('product'));
        }
        else
        {
            return Redirect()->route('products')
            ->withErrors(["product_id"=>'The product no found']);
        }
    }
}

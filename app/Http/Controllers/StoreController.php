<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('store.store',compact('products'));
    }
    public function show($id)
    {
        $product=Product::find($id);
        return view('store.show',compact('product'));
    }
}

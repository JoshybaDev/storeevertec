@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ url('css/style_store.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('head')
    @include('store.header')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-4 text-center fw-bold">
            <br>
            <h2>{{ $product->name }}</h2>

            <h4>${{ number_format($product->price, 2) }}</h4>
            <br>
            <form action="cart" method="post" class="fs-base mx-2" style="display: inline">
                <input type="hidden" name="idprodcut" value="{{ $product->id }}">
                <button class="btn btn-primary" alt="add cart">ADD TO CART</button>
            </form>
            <br><br>
            <a href="{{route('products')}}" class="btn btn-danger">BACK PRODUCTS</a>
        </div>
        <div class="col-lg-5">
            <img src="{{ url('img/products/01.jpg') }}" alt="" width="80%" height="80%" class="rounded">
        </div>
    </div>
@endsection

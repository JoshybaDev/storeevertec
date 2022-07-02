@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ url('css/style_store.css') }}">
    <link rel="stylesheet" href="{{ url('css/style_cart.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('head')
    @include('store.header')
@endsection
@section('content')
    @if (count($items) > 0)
        <div class="container cartcontainer mb-5 pb-3">
            <div class="card">
                <div class="card-body">
                    @include("layouts.errors")                    
                    <div class="row">
                        <div class="col-lg-8">
                            @foreach ($items as $item)
                                <div class="align-items-center py-4 border-bootom">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <a><img src="{{ url('img/products/01.jpg') }}" alt=""
                                                    width="150px"></a>
                                        </div>
                                        <div class="col align-middle">
                                            <span class="fw-bold">{{ $item['product_name'] }}</span>
                                            <br>
                                            ${{ $item['product_price'] }}
                                        </div>
                                        <div class="col text-center">
                                            {{ $item['product_cant'] }}
                                        </div>
                                        <div class="col text-center">
                                            ${{ number_format($item['product_subtotal'], 2) }} &nbsp;&nbsp;&nbsp;
                                            <form action="{{ route('cartDel',['id'=>$item['product_id']]) }}" method="post" style="display: inline">
                                                {{ method_field('delete') }}
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$item['product_id']}}">
                                                <button class="btn btn-danger" title="Remove Product">
                                                    <i class="icon-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-lg-4 text-center border-start">
                            Subtotal &nbsp;&nbsp; <span class="fw-bold fs-3">${{ number_format($total, 2) }}</span>
                            <br><br>
                            <button class="btn btn-dark">CHECKOUT</button>
                            <br>
                            <a href="{{ route('products') }}">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 text-center fw-bold fs-3">
                <br><br>
                {{ __('Your cart is empty! Sounds like a good time to ') }}
                <a href="{{ route('products') }}">{{ __('start shopping.') }}</a>
            </div>

        </div>
    @endif
@endsection
@section('scripts')
    <script src="{{ url('js/cart.js?version=' . date('mdhs')) }}"></script>
@endsection

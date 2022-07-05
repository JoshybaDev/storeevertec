@extends('layouts.app')
@section('title', 'Checkout')
@section('css')
    <link rel="stylesheet" href="{{ url('css/borders.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('content')
    <div class="container">
        @include('layouts.errors')
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-3">Checkout</div>
                            <div class="col-lg-6"></div>
                            <div class="col-lg-3"><a href="{{ route('cart') }}"> Back to cart</a></div>
                        </div>
                        <form action="{{ route('checkout2') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user['user_id'] }}">
                            <div class="row mb-3">
                                <div class="col-lg-12 text-center">
                                    <hr><span class="fw-bold fs-4">Contact Information</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10"><input type="text" name="user_name" id="name"
                                        class="form-control" required placeholder="Name" value="{{ $user['user_name'] }}"
                                        maxlength="80"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10"><input type="text" name="user_mobile" id="mobile"
                                        class="form-control" required placeholder="Mobile"
                                        value="{{ $user['user_mobile'] }}" maxlength="40"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-1"></div>
                                <div class="col-lg-10"><input type="email" name="user_email" id="email"
                                        class="form-control" required placeholder="Email"
                                        value="{{ $user['user_email'] }}" maxlength="120"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4 text-center"><button class="btn btn-dark px-5">NEXT</button></div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <hr><span class="fw-bold fs-4">Order Summary</span>
                            </div>
                        </div>
                        @php
                            $cart = true;
                        @endphp
                        @foreach ($items as $item)
                            @include('checkout.item_producto')
                        @endforeach
                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                Subtotal
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3 text-end">
                                ${{ number_format($total, 2) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                Shipping
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3 text-end">
                                Pending
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                Tax
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3 text-end">
                                Pending
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                Total
                            </div>
                            <div class="col-lg-4"></div>
                            <div class="col-lg-3 text-end">
                                ${{ number_format($total, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

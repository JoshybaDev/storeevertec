@extends('layouts.app')
@section('title', 'My order')
@section('css')
    <link rel="stylesheet" href="{{ url('css/style_pay.css') }}">
    <link rel="stylesheet" href="{{ url('css/tooltip.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('content')
    <div class="card" style="width: 800px;margin:auto">
        <div class="card-body">
            <div class="car-head">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="alert alert-info text-center fw-bold ">
                            {{ $codeunique }}
                            <div class="float-end cursor" onclick="copyCode2('{{ $codeunique }}');">
                                <div class="w3-tooltip">
                                    <i class="icon-copy"></i>
                                    <span class="w3-tooltiptext" id="myTooltip">Copy your code order</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="alert alert-success text-center fw-bold ">
                            <span>PAYED</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <hr><span class="fw-bold fs-4">Order Summary</span>
                    </div>
                </div>
                @php
                    $cart = false;
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
                        ${{ number_format($order[0]['shipping'], 2) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        Tax
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-3 text-end">
                        ${{ number_format($order[0]['tax'], 2) }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        Discount
                    </div>
                    <div class="col-lg-4"></div>
                    <div class="col-lg-3 text-end">
                        ${{ number_format($order[0]['shipping_discount'], 2) }}
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
                <div class="mb-2">&nbsp;</div>
                <div class="card" style="width: 800px;margin:auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Receive Order</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                Client:
                            </div>
                            <div class="col-lg-3">
                                {{ $order[0]['customer_name'] }} {{ $order[0]['customer_surname'] }}
                            </div>
                            <div class="col-lg-2">
                                Email:
                            </div>
                            <div class="col-lg-5">
                                {{ $order[0]['customer_email'] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                Mobile:
                            </div>
                            <div class="col-lg-2">
                                {{ $order[0]['customer_mobile'] }}
                            </div>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>
    </div>
@endsection

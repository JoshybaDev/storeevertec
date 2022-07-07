@extends('layoutsadmin.app')
@section('title', 'My Orders')
@section('css')
    <link rel="stylesheet" href="{{ url('css/tooltip.css') }}">
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800"><a href="{{ route('orders') }}">Orders</a> / Order {{ $order[0]['id'] }} </h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Order {{ $order[0]['id'] }}</h6>
        </div>
        <div class="card-body">
            <div class="card" style="width: 800px;margin:auto">
                <div class="card-body">
                    <div class="car-head">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="alert alert-info text-center fw-bold ">
                                    {{ $order[0]['codebuy'] }}
                                    <div class="float-end cursor" onclick="copyCode2('{{ $order[0]['codebuy'] }}');">
                                        <div class="w3-tooltip">
                                            <i class="fa fa-copy"></i>
                                            <span class="w3-tooltiptext" id="myTooltip">Copy your code order</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                @php
                                    $color='';
                                    if ($order[0]['status'] == 'CREATED') {
                                        $color='alert-primary';
                                    } elseif ($order[0]['status'] == 'REJECTED') {
                                        $color='alert-danger';
                                    } elseif ($order[0]['status'] == 'PAYED') {
                                        $color='alert-success';
                                    }
                                @endphp
                                <div class="alert {{ $color }} text-center fw-bold ">
                                    <span>{{ $order[0]['status'] }}</span>
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
                                ${{ number_format($order[0]['total'], 2) }}
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
                                ${{ number_format($order[0]['total'], 2) }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @if ($order[0]['status'] == 'PAYED' || $order[0]['status'] == 'REJECTED' || $order[0]['status'] == 'SENDED')
                <div class="mb-2">&nbsp;</div>
                <div class="card" style="width: 800px;margin:auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Details of payment</h6>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

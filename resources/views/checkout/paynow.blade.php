@extends('layouts.app')
@section('title', 'Payment')
@section('css')
    <link rel="stylesheet" href="{{ url('css/style_pay.css') }}">
    <link rel="stylesheet" href="{{ url('css/tooltip.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('content')
    <div class="container">
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
                            <div class="alert alert-warning text-center fw-bold ">
                                <span>PAY PENDING</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <section class="col-lg-12">
                        <div class="accordion mb-2" id="payment-method">
                            <div class="accordion-item">
                                <h3 class="accordion-header"><a class="accordion-button" href="#card"
                                        data-bs-toggle="collapse"><i class="ci-card fs-lg me-2 mt-n1 align-middle"></i>
                                        <img src="{{ url('img/placetopay-logo.svg') }}" alt="" width="170px"></a>
                                </h3>
                                <div class="accordion-collapse collapse show" id="card"
                                    data-bs-parent="#payment-method">
                                    <div class="accordion-body">
                                        @include('layouts.errors')
                                        <form method="post" action="{{ route('startProcessPay') }}">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user['user_id'] }}">
                                            <input type="hidden" name="codeunique" value="{{ $codeunique }}">
                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-outline-primary mt-0 px-5" type="submit">Pay
                                                    Now</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
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
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection

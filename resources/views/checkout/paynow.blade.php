@extends('layouts.app')
@section('title', 'Payment')
@section('css')
    <link rel="stylesheet" href="{{ url('css/style_pay.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="card" style="width: 800px;margin:auto">
            <div class="card-body">
                <div class="row">
                    <section class="col-lg-12">

                        <h2 class="h6 pb-3 mb-2">Choose payment method</h2>
                        <div class="accordion mb-2" id="payment-method">
                            <div class="accordion-item">
                                <h3 class="accordion-header"><a class="accordion-button" href="#card"
                                        data-bs-toggle="collapse"><i class="ci-card fs-lg me-2 mt-n1 align-middle"></i>Pay
                                        with Credit Card</a></h3>
                                <div class="accordion-collapse collapse show" id="card"
                                    data-bs-parent="#payment-method">
                                    <div class="accordion-body">
                                        <p class="fs-sm">We accept following credit cards:&nbsp;&nbsp;<img
                                                class="d-inline-block align-middle" src="{{ url('img/cards.png') }}"
                                                alt="Cerdit Cards" width="187"></p>
                                        <div class="credit-card-wrapper" data-jp-card-initialized="true">
                                            <div class="jp-card-container">
                                                <div class="jp-card">
                                                    <div class="jp-card-front">
                                                        <div class="jp-card-logo jp-card-elo">
                                                            <div class="e">e</div>
                                                            <div class="l">l</div>
                                                            <div class="o">o</div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-visa">Visa</div>
                                                        <div class="jp-card-logo jp-card-visaelectron">Visa<div
                                                                class="elec">Electron
                                                            </div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-mastercard">Mastercard</div>
                                                        <div class="jp-card-logo jp-card-maestro">Maestro
                                                        </div>
                                                        <div class="jp-card-logo jp-card-amex"></div>
                                                        <div class="jp-card-logo jp-card-discover">discover</div>
                                                        <div class="jp-card-logo jp-card-unionpay">UnionPay</div>
                                                        <div class="jp-card-logo jp-card-dinersclub"></div>
                                                        <div class="jp-card-logo jp-card-hipercard">Hipercard</div>
                                                        <div class="jp-card-logo jp-card-troy">troy</div>
                                                        <div class="jp-card-logo jp-card-dankort">
                                                            <div class="dk">
                                                                <div class="d"></div>
                                                                <div class="k"></div>
                                                            </div>
                                                        </div>
                                                        <div class="jp-card-logo jp-card-jcb">
                                                            <div class="j">J</div>
                                                            <div class="c">C</div>
                                                            <div class="b">B</div>
                                                        </div>
                                                        <div class="jp-card-lower">
                                                            <div class="jp-card-shiny"></div>
                                                            <div class="jp-card-cvc jp-card-display jp-card-invalid">•••
                                                            </div>
                                                            <div class="jp-card-number jp-card-display jp-card-invalid">••••
                                                                •••• ••••
                                                                ••••
                                                            </div>
                                                            <div class="jp-card-name jp-card-display jp-card-invalid">Full
                                                                Name</div>
                                                            <div class="jp-card-expiry jp-card-display jp-card-invalid"
                                                                data-before="month/year" data-after="validthru">••/••</div>
                                                        </div>
                                                    </div>
                                                    <div class="jp-card-back">
                                                        <div class="jp-card-bar"></div>
                                                        <div class="jp-card-cvc jp-card-display jp-card-invalid">•••</div>
                                                        <div class="jp-card-shiny"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form class="credit-card-form row">
                                            <div class="mb-3 col-sm-6">
                                                <input class="form-control jp-card-invalid" type="text" name="number"
                                                    placeholder="Card Number" required="">
                                            </div>
                                            <div class="mb-3 col-sm-6">
                                                <input class="form-control jp-card-invalid" type="text" name="name"
                                                    placeholder="Full Name" required="">
                                            </div>
                                            <div class="mb-3 col-sm-3">
                                                <input class="form-control jp-card-invalid" type="text" name="expiry"
                                                    placeholder="MM/YY" required="">
                                            </div>
                                            <div class="mb-3 col-sm-3">
                                                <input class="form-control jp-card-invalid" type="text" name="cvc"
                                                    placeholder="CVC" required="">
                                            </div>
                                            <div class="col-sm-6">
                                                <button class="btn btn-outline-primary d-block w-100 mt-0"
                                                    type="submit">Submit</button>
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
@endsection
@section('scripts')
    <script src="{{ url('js/card.js') }}"></script>
    <script>
      window.onload = () =>{
        let e = document.querySelector(".credit-card-form");
        new Card({
            form: e,
            container: ".credit-card-wrapper",
            formSelectors: {
                nameInput: 'input[name="first-name"], input[name="last-name"]'
            }
        });
      }
    </script>

@endsection

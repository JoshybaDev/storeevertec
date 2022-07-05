@extends('layouts.app')
@section('title', 'shipping')
@section('css')
    <link rel="stylesheet" href="{{ url('css/borders.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('content')
    <div class="container mb-5 pb-3">
        @include('layouts.errors')
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-3">Shipping</div>
                            <div class="col-lg-6"></div>
                            <div class="col-lg-3"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-lg-12">
                                <span class="fw-bold">Congratulations your code unique for order is:</span><br>
                                <div class="alert alert-info text-center fw-bold cursor">
                                    {{ $codeunique }}
                                    <div class="float-end" onclick="copyCode2('{{ $codeunique }}');">
                                        <div class="w3-tooltip">
                                            <i class="icon-copy"></i>
                                            <span class="w3-tooltiptext" id="myTooltip">Copy your code order</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('checkout6', ['codeunique' => $codeunique]) }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user['user_id'] }}">
                            <input type="hidden" name="codeunique" value="{{ $codeunique }}">
                            <div class="row mb-3">
                                <div class="col-lg-12 text-center">
                                    <hr><span class="fw-bold fs-4">Choose shipping method</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Shipping method</th>
                                                <th class="text-center">Delivery time</th>
                                                <th class="text-center">Handling fee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($listPackages as $package)
                                                <tr>
                                                    <td>
                                                        <input type="radio" name="package_id" id="package_id"
                                                            value="{{ $package->id }}" required>
                                                        {{ $package->name }}<br><span
                                                            class="text-secondary">{{ $package->country_scope }}</span>
                                                    </td>
                                                    <td class="text-center">25 - 35 days</td>
                                                    <td class="text-end">$0.00</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button class="btn btn-danger px-3">Proceed to Payment</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <hr><span class="fw-bold fs-4">SUMMARY</span>
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
        </div>
        @auth
            {{-- Cant select direction or capture new --}}
        @else
            {{-- only capture --}}
        @endauth
    </div>
@endsection

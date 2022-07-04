@extends('layouts.app')
@section('title','Address')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
    <link rel="stylesheet" href="{{ url('css/tooltip.css') }}">
@endsection
@section('content')
    @include('layouts.errors')
    <div class="container mb-5 pb-3">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-lg-3">Shipping address</div>
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
                        <form action="{{ route('checkout4') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user['user_id'] }}">
                            <input type="hidden" name="codeunique" value="{{ $codeunique }}">
                            <div class="row mb-3">
                                <div class="col-lg-12 text-center">
                                    <hr><span class="fw-bold fs-4">Shipping address</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-12"><input type="text" name="street" id="street"
                                        class="form-control" required placeholder="Street" value="" maxlength="80" required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6"><input type="text" name="city" id="city"
                                        class="form-control" required placeholder="City" value="" maxlength="40" required>
                                </div>
                                <div class="col-lg-6"><input type="state" name="state" id="state"
                                        class="form-control" required placeholder="State" maxlength="120" required></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-lg-6"><input type="zipcode" name="zipcode" id="zipcode"
                                    class="form-control" required placeholder="Zip Code" maxlength="120" required></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4 text-center"><button class="btn btn-dark px-5">NEXT</button></div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <hr><span class="fw-bold fs-4">SUMMARY</span>
                            </div>
                        </div>
                        @foreach ($items as $item)
                            <div class="row border-bootom_claro mb-2">
                                <div class="col-lg-5">
                                    {{ $item['name'] }}<br>
                                    {{ $item['cant'] }} x ${{ number_format($item['price'], 2) }}
                                </div>
                                <div class="col-lg-4"></div>
                                <div class="col-lg-3 text-end aling-middle">
                                    ${{ number_format($item['subtotal'], 2) }}
                                </div>
                            </div>
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
@section('scripts')
    <script src="{{ url('js/functions.js') }}"></script>
@endsection

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
                            <div class="col-lg-12">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @endif
                            </div>
                        </div>
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
                                        $color='alert-warning';
                                    } elseif ($order[0]['status'] == 'REJECTED') {
                                        $color='alert-danger';
                                    } elseif ($order[0]['status'] == 'PAYED') {
                                        $color='alert-success';
                                    } elseif ($order[0]['status'] == 'SENDED') {
                                        $color='alert-primary';
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
            @if ($order[0]['status'] == 'PAYED' || $order[0]['status'] == 'REJECTED' || $order[0]['status'] == 'SENDED')
                <div class="mb-2">&nbsp;</div>
                <div class="card" style="width: 800px;margin:auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Details of payment</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                Status:
                            </div>
                            <div class="col-lg-2">
                                {{ $orderPay[0]['status_pay'] }}
                            </div>
                            <div class="col-lg-2">
                                Message:
                            </div>
                            <div class="col-lg-6">
                                {{ $orderPay[0]['status_message'] }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                Request Id:
                            </div>
                            <div class="col-lg-2">
                                {{ $orderPay[0]['request_id'] }}
                            </div>
                            <div class="col-lg-8 text-center">
                                @if ($order[0]['status'] == 'PAYED' || $order[0]['status'] == 'SENDED')
                                    <a class="btn btn-info" href="#" data-toggle="modal" data-target="#PayedInfoModal"
                                        onclick="getDataPay('{{ route('order.showUrlPay', ['id' => $orderPay[0]['id']]) }}')">See
                                        info to
                                        PlacetoPay</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (Auth()->user()->level == 'ADMIN' && $order[0]['status'] == 'PAYED')
                <div class="mb-2">&nbsp;</div>
                <div class="card" style="width: 800px;margin:auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Dispatch order</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('order.sended') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth()->user()->id }}">
                            <input type="hidden" name="order_id" value="{{ $order[0]['id'] }}">
                            <div class="row mb-4">
                                <div class="col-lg-4 text-right">Tracking number:</div>
                                <div class="col-lg-6"><input type="text" name="tracking_number" id="tracking_number"
                                        class="form-control" required maxlength="50"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-10 text-center">
                                    <button class="btn btn-primary px-5">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            @if ($order[0]['status'] == 'SENDED')
                <div class="mb-2">&nbsp;</div>
                <div class="card" style="width: 800px;margin:auto">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Details of Shipping</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                Street:
                            </div>
                            <div class="col-lg-4">
                                {{ $orderAddress[0]['street'] }}
                            </div>
                            <div class="col-lg-2">
                                City:
                            </div>
                            <div class="col-lg-4">
                                {{ $orderAddress[0]['city'] }}
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-2">
                                State:
                            </div>
                            <div class="col-lg-4">
                                {{ $orderAddress[0]['state'] }}
                            </div>
                            <div class="col-lg-2">
                                Zip Code:
                            </div>
                            <div class="col-lg-4">
                                {{ $orderAddress[0]['zipcode'] }}
                            </div>
                        </div>
                        @if ($orderPackage)
                            <div class="row mb-4">
                                <div class="col-lg-2">
                                    Tracking Number:
                                </div>
                                <div class="col-lg-4">
                                    {{ $orderPackage[0]['tracking_number'] }}
                                </div>
                                <div class="col-lg-2">
                                    
                                </div>
                                <div class="col-lg-4">
                                    
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    @if ($order[0]['status'] == 'PAYED')
        <div class="modal fade" id="PayedInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Information of pay</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="idcontent"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script src="{{ url('js/orders.js') }}"></script>
@endsection

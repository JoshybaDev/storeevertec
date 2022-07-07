@extends('layoutsadmin.app')
@section('title', 'My Orders')
@section('css')
<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
@endsection
@section('content')
    <h1 class="h3 mb-2 text-gray-800">My Orders</h1>
    <p class="mb-2">&nbsp;</p>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List of orders</h6>
        </div>
        <div class="card-body">
            <table class="table table-border table-hover table-striped">
                <thead>
                    <tr class="table-primary">
                        <th>Id</th>
                        <th>Client</th>
                        <th>Code</th>
                        <th>Date</th>
                        <th>Cant</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $color='';
                            if ($order['status'] == 'CREATED') {
                                $color='btn-primary';
                            } elseif ($order['status'] == 'REJECTED') {
                                $color='btn-danger';
                            } elseif ($order['status'] == 'PAYED') {
                                $color='btn-success';
                            }
                        @endphp
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>{{ $order['customer_name'] }} {{ $order['customer_surname'] }}</td>
                            <td>{{ $order['codebuy'] }}</td>
                            <td>{{ $order['created_at'] }}</td>
                            <td>{{ $order['cant'] }}</td>
                            <td>${{ number_format($order['total'], 2) }}</td>
                            <td class="text-center"><a class="btn {{ $color }}"
                                    href="{{ route('orders.show', ['id' => $order['id']]) }}">{{ $order['status'] }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
@endsection

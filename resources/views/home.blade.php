@extends('layoutsadmin.app')
@section('content')
<h1 class="h3 mb-4 text-gray-800">Home</h1>
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4 text-center"><a class="btn btn-success" href="{{route('orders')}}">Show My Orders</a></div>
</div>
@endsection
@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
@section('content')
<div class="container mb-5 pb-3">
    <div class="row">
        <div class="col-lg-2"></div>
        <div class="col-lg-8 text-center">
            <span class="text-primary" style="font-size: 205px">404</span>
            <br>
            <h1 class="fw-bold">We can't seem to find the page you are looking for.</h1>
            <a class="btn btn-info" href="{{route('products')}}">
                <i class="icon-home"></i>&nbsp;&nbsp;&nbsp;<h3 style="display:inline-block">Home</h3>
                
            </a>
        </div>
    </div>
</div>
@endsection
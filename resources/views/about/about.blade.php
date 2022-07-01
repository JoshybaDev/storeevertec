@extends('layouts.app')
@section('title','About me')
@section('head')
<div class="container">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="products" class="nav-link {{Route::current()->uri=='products' ? 'active' : ''}}" aria-current="page">Products</a></li>
        <li class="nav-item"><a href="cart" class="nav-link {{Route::current()->uri=='cart' ? 'active' : ''}}">Cart</a></li>
        <li class="nav-item"><a href="about" class="nav-link {{Route::current()->uri=='about' ? 'active' : ''}}">About</a></li>
      </ul>
    </header>
  </div>
@endsection
@section('content')
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4 text-center fw-bold">
            Development by<br>
            Ing. José Israel Gómez Rrodríguez
        </div>
    </div>
</div>
@endsection
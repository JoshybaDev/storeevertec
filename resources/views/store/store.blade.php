@extends('layouts.app')
@section('css')
  <link rel="stylesheet" href="{{url('css/style_store.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.0.0/css/font-awesome.css">
@endsection
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
<div class="row pt-3 mx-n2">
  @foreach ($products as $anProduct)
  <!-- Product-->
  <div class="col-lg-3 col-md-4 col-sm-6 px-2 mb-grid-gutter">
    <div class="card product-card-alt">
      <div class="product-thumb">
        <div class="product-card-actions"><a class="btn btn-light btn-icon btn-shadow fs-base mx-2" href="{{route('products').'/'.$anProduct->id}}""><i class="icon-eye-open"></i></a>
            <form action="cart" method="post" class="fs-base mx-2" style="display: inline">
              <input type="hidden" name="idprodcut" value="{{$anProduct->id}}">
              <button class="btn btn-light btn-icon btn-shadow" alt="add cart"><i class="icon-shopping-cart"></i></button>
            </form>            
        </div><a class="product-thumb-overlay" href="{{route('products').'/'.$anProduct->id}}"></a><img src="{{url('img/products/01.jpg')}}" alt="Product">
      </div>
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between align-items-start pb-2">
          <div class="text-muted fs-xs me-1">{{$anProduct->name}}</a></div>
          <div class="star-rating"><i class="icon-star active"></i><i class="icon-star active"></i><i class="icon-star active"></i><i class="icon-star active"></i><i class="icon-star active"></i>
          </div>
        </div>
        <div class="d-flex flex-wrap justify-content-between align-items-center">
          <div class="fs-sm me-2"><i class="ci-download text-muted me-1"></i>109<span class="fs-xs ms-1">Sales</span></div>
          <div class="bg-faded-accent text-accent rounded-1 py-1 px-2">${{number_format($anProduct->price,2)}}</div>
        </div>
      </div>
    </div>
  </div>
  @endforeach  
</div>
</div>
@endsection
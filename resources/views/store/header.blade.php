<div class="container">
    <header class="d-flex justify-content-center py-3">
      <ul class="nav nav-pills">
        <li class="nav-item"><a href="{{route('products')}}" class="nav-link {{Route::current()->uri=='products' ? 'active' : ''}}" aria-current="page">Products</a></li>
        <li class="nav-item"><a href="{{route('cart')}}" class="nav-link {{Route::current()->uri=='cart' ? 'active' : ''}}">Cart</a></li>
        <li class="nav-item"><a href="{{route('about')}}" class="nav-link {{Route::current()->uri=='about' ? 'active' : ''}}">About</a></li>
      </ul>
    </header>
  </div>
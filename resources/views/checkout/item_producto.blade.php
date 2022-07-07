@if ($cart)
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0" href="#"><img
                        src="{{ url('img/products/01.jpg') }}" alt="Product" width="64"></a>
                <div class="ps-2">
                    <h6 class="widget-product-title"><a href="#">{{ $item['product_name'] }}</a></h6>
                    <div class="widget-product-meta"><span
                            class="text-accent me-2">${{ number_format($item['product_price'], 2) }}</span><span
                            class="text-muted">x {{ $item['product_cant'] }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-end aling-middle">
            ${{ number_format($item['product_subtotal'], 2) }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-lg-8">
            <div class="d-flex align-items-center pb-2 border-bottom"><a class="d-block flex-shrink-0"
                    href="#"><img src="{{ url('img/products/01.jpg') }}" alt="Product" width="64"></a>
                <div class="ps-2">
                    <h6 class="widget-product-title"><a href="#">{{ $item['name'] }}</a></h6>
                    <div class="widget-product-meta"><span
                            class="text-accent me-2">${{ number_format($item['price'], 2) }}</span><span
                            class="text-muted">x {{ $item['cant'] }}</span></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 text-end aling-middle">
            ${{ number_format($item['subtotal'], 2) }}
        </div>
    </div>
@endif

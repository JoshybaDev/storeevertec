<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>My Order</title>
</head>

<body>
    <div class="container">
        <div
            style="font-family: arial, sans-serif; border-spacing: 0; color:=#707173; margin: 0 auto 15px auto;
        background: #ffd900; font-size: 25px;">
            <p style="text-align:center; padding: 10px 30px; color: #cc581c;">StoreEvertec</p>
        </div>
        <div style="position: relative;display: flex;flex-direction: column; min-width: 0;word-wrap: break-word;background-color: #fff; background-clip: border-box; border: 1px solid rgba(0, 0, 0, 0.125); border-radius: 0.25rem;width: 800px;margin:auto">
            <div style="flex: 1 1 auto;padding: 1rem 1rem;">
                <div class="car-head">
                    <table style="width: 100%">
                        <tr style="margin-bottom: 10px">
                            <td colspan="2" style="text-align: center">
                                Hello <span style="font-weight: bold;font-size: 1rem">{{$dataEmail['order'][0]['customer_name']}} {{$dataEmail['order'][0]['customer_surname']}}  </span>                               
                            </td>
                        </tr>                        
                        <tr style="margin-bottom: 10px">
                            <td colspan="2">
                                Thank you, your order has been created successfully, now you just have to make the payment,
                                this is the data of your order:                                
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">your code of order</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="width: 50%;padding:10px">
                                <div style="position: relative; padding: 1rem 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;
                                  color: #055160;  background-color: #cff4fc; border-color: #b6effb;;text-align: center">
                                    <a href="{{ route('checkoutshow', ['codeunique' => $dataEmail['codeunique']]) }}">
                                        {{ $dataEmail['codeunique'] }}
                                    </a>
                                </div>                                
                            </td>
                            <td style="width: 50%;padding:10px">
                                <div style="position: relative; padding: 1rem 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem;  color: #0f5132;
                                background-color: #d1e7dd;border-color: #badbcc;text-align:center">
                                    <span>ORDERED</span>
                                </div>                                
                            </td>
                        </tr>
                    </table>
                </div>
                <table style="width: 100%">
                    <tr>
                        <td colspan="2" style="text-align: center"><span
                                style="font-weight: 700;font-size: 1.35rem">Order Summary</span></td>
                    </tr>
                    @foreach ($dataEmail['items'] as $item)
                        <tr>
                            <td>
                                <div
                                    style="display: flex;align-items: center;padding-bottom: 0.5rem;border-bottom: 1px solid #e3e9ef">
                                    <a style="display: block;flex-shrink: 0" href="#">
                                        <img src="{{ url('img/products/01.jpg') }}" alt="Your product" width="64">
                                    </a>
                                    <div style="padding-left: 0.5rem">
                                        <h6><a href="#">{{ $item['name'] }}</a></h6>
                                        <div>
                                            <span
                                                style="margin-right: 0.5rem">${{ number_format($item['price'], 2) }}</span>
                                            <span>x {{ $item['cant'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="text-align: right;">
                                    ${{ number_format($item['subtotal'], 2) }}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2">
                            <hr
                                style="margin: 1rem 0;color: inherit;background-color: #f8f9fa;border: 1;opacity: 0.25;">
                        </td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td style="text-align: right;">${{ number_format($dataEmail['order'][0]['total'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Shipping</td>
                        <td style="text-align: right;">${{ number_format($dataEmail['order'][0]['shipping'], 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td style="text-align: right;">${{ number_format($dataEmail['order'][0]['tax'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td style="text-align: right;">
                            ${{ number_format($dataEmail['order'][0]['shipping_discount'], 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr
                                style="margin: 1rem 0;color: inherit;background-color: #f8f9fa;border: 1;opacity: 0.25;">
                        </td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td style="text-align: right;">${{ number_format($dataEmail['order'][0]['total'], 2) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Helpers\Helper;
use App\Models\OrderDetail;
use App\Models\UserAddress;
use App\Models\OrderAddress;
use App\Models\OrderPayData;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Database\Eloquent\Collection;

final class PayProcessService
{
    public bool $error = false;
    public string $errorMessage = '';
    public string $message = '';
    public string $processUrl = '';
    private string $requestId = '';
    public string $status = '';
    /**
     * Create new object PlacetoPay
     *
     * @return PlacetoPay
     */
    private function createObject(): PlacetoPay
    {
        return new PlacetoPay([
            'login' => env('PLACETOPAY_LOGIN'), // YOUR_LOGIN Provided by PlacetoPay
            'tranKey' => env('PLACETOPAY_TRANKEY'), // YOUR_TRANSACTIONAL_KEY Provided by PlacetoPay
            'baseUrl' => env('PLACETOPAY_URL'),
            'timeout' => 10, // (optional) 15 by default
        ]);
    }
    /**
     * Request full
     *
     * @param [string] $codeunique
     * @return void
     */
    public function createRequest(string $codeunique): bool
    {
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $orderPayData = OrderPayData::where('order_id', '=', $order[0]["id"])->get();
        if ($orderPayData->isEmpty() || $order[0]['status'] === 'REJECTED') {
            $request = $this->createDataForProcessPay($codeunique);
            try {
                $placetopay = $this->createObject();
                $response = $placetopay->request($request);
                Helper::logWrite($response->processUrl());
                Helper::logWrite($response->requestId());
                Helper::logWrite($response->status()->status());
                Helper::logWrite($response->status()->reason());
                Helper::logWrite($response->status()->message());
                Helper::logWrite($response->status()->date());
                Helper::logWrite($response->isSuccessful());
                Helper::logWrite("          ");
                Helper::logWrite("          ");
                Helper::logWrite("-------------------");
                if ($response->isSuccessful()) {
                    $this->processUrl = $response->processUrl(); //string
                    $this->requestId = $response->requestId(); //string
                    $this->saveInformation($order[0]["id"], $orderPayData->isEmpty());
                    $this->message = $response->status()->message();
                    return true;
                } else {
                    // There was some error so check the message
                    $this->message = $response->status()->message();
                    return false;
                }
            } catch (Exception $e) {
                $this->error = true;
                $this->errorMessage = $e->getMessage();
                return false;
            }
        }
        return false;
    }
    /**
     * Create request Minimi
     *
     * @param [type] $codeunique
     * @return void
     */
    public function createRequestMinimum($codeunique)
    {
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $orderPayData = OrderPayData::where('order_id', '=', $order[0]["id"])->get();
        if ($orderPayData->isEmpty() || $order[0]['status'] === 'REJECTED') {
            $request = [
                'payment' => [
                    'reference' => $codeunique,
                    'description' => 'Testing payment storeevertec',
                    'amount' => [
                        'currency' => 'USD',
                        'total' => (float)$order[0]["total"],
                    ],
                ],
                'expiration' => date('c', strtotime('+2 days')),
                'returnUrl' => env('APP_URL') . '/responseProcessPay?codeunique=' . $codeunique,
                'ipAddress' => env('APP_IP'),
                'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
            ];

            try {
                $placetopay = $this->createObject();
                $response = $placetopay->request($request);
                if ($response->isSuccessful()) {
                    $this->processUrl = $response->processUrl(); //string
                    $this->requestId = $response->requestId(); //string               
                    $this->saveInformation($order[0]["id"], $orderPayData->isEmpty());
                    $this->message = $response->status()->message();
                    return true;
                } else {
                    // There was some error so check the message
                    $this->error = true;
                    $this->message = $response->status()->message();
                    return false;
                }
            } catch (Exception $e) {
                $this->error = true;
                $this->errorMessage = $e->getMessage();
                return false;
            }
        }
        return false;
    }
    /**
     * Create array the user shipping
     *
     * @param Illuminate\Database\Eloquent\Collection $order
     * @return array
     */
    public function createUserShipping(Collection $order): array
    {
        return $this->createPayerBuyer($order);
    }
    /**
     * Create payer and buyer
     *
     * @param Illuminate\Database\Eloquent\Collection $order
     * @return array
     */
    private function createPayerBuyer(Collection $order): array
    {
        return [
            'name' => $order[0]['customer_name'],
            'surname' => $order[0]['customer_surname'],
            'email' => $order[0]['customer_email'],
            'documentType' => 'CC',
            'document' => '1848839248',
            'mobile' => $order[0]['customer_mobile'],
            'address' => $this->getAddress($order[0]["user_id"], $order[0]["id"], $order[0]['customer_mobile']),
        ];
    }
    /**
     * Get address if user_id = 0 return addressshipping else useraddress
     *
     * @param integer $orderId
     * @param string $phone
     * @return array
     */
    private function getAddress(int $userId, int $orderId, string $phone): array
    {
        if ($userId == 0) {
            return $this->getAddressShipping($orderId, $phone);
        } else {
            return $this->getUserAddres($userId, $phone);
        }
    }
    /**
     * Get addres of shipping
     *
     * @param integer $orderId
     * @param string $phone
     * @return array
     */
    private function getAddressShipping(int $orderId, string $phone): array
    {
        $orderAddressData = OrderAddress::where('order_id', '=', $orderId)->get();
        return [
            'street' => $orderAddressData[0]['street'],
            'city' => $orderAddressData[0]['city'],
            'state' => $orderAddressData[0]['state'],
            'postalCode' => $orderAddressData[0]['zipcode'],
            'country' => 'US',
            'phone' => $phone,
        ];
    }
    /**
     * Get user address
     *
     * @param integer $userId
     * @param string $phone
     * @return array
     */
    private function getUserAddres(int $userId, string $phone): array
    {
        $orderAddressData = UserAddress::where('user_id', '=', $userId)->get();
        return [
            'street' => $orderAddressData[0]['street'],
            'city' => $orderAddressData[0]['city'],
            'state' => $orderAddressData[0]['state'],
            'postalCode' => $orderAddressData[0]['zipcode'],
            'country' => 'US',
            'phone' => $phone,
        ];
    }
    /**
     * Get all products of orderdetails
     *
     * @param integer $orderId
     * @return array
     */
    public function getItemsOrder(int $orderId): array
    {
        $items = [];
        $orderAddressData = OrderDetail::where('order_id', '=', $orderId)->get();
        foreach ($orderAddressData as $key => $value) {
            $item = [
                'sku' => $value['product_id'],
                'name' => $value['name'],
                'category' => 'physical',
                'qty' => $value['cant'],
                'price' => $value['price'],
                'tax' => 0,
            ];
            array_push($items, $item);
        }
        return $items;
    }
    /**
     * Save information of pay response
     *
     * @param integer $orderId
     * @return void
     */
    private function saveInformation(int $orderId, bool $IsEmpty): void
    {
        if ($IsEmpty) {
            OrderPayData::create([
                'order_id' => $orderId,
                'proccess_url' => $this->processUrl,
                'request_id' => $this->requestId,
            ]);
        } else {
            OrderPayData::where('order_id', '=', $orderId)
                ->update([
                    'proccess_url' => $this->processUrl,
                    'request_id' => $this->requestId,
                ]);
        }
    }
    /**
     * Status of pay order
     *
     * @param [type] $codeunique
     * @return void
     */
    public function estatusPay($codeunique): void
    {
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $orderPayData = OrderPayData::where('order_id', '=', $order[0]["id"])->get();
        if (!$orderPayData->isEmpty()) {
            $placetopay = $this->createObject();
            $response = $placetopay->query($orderPayData[0]['request_id']);
            //read to info ==> $response->request()->returnUrl());
            if ($response->isSuccessful()) {
                if ($response->status()->isApproved()) {
                    Order::where('codebuy', '=', $codeunique)
                        ->update([
                            'status' => 'PAYED'
                        ]);
                    OrderPayData::where('order_id', '=', $order[0]["id"])
                        ->update([
                            'status_pay' => $response->status()->status(),
                            'status_mesage' => $response->status()->message(),
                            'status_date' => $response->status()->date()
                        ]);
                } elseif ($response->status()->status() == 'REJECTED') {
                    Order::where('codebuy', '=', $codeunique)
                        ->update([
                            'status' => 'REJECTED'
                        ]);
                    OrderPayData::where('order_id', '=', $order[0]["id"])
                        ->update([
                            'status_pay' => $response->status()->status(),
                            'status_mesage' => $response->status()->message(),
                            'status_date' => $response->status()->date()
                        ]);
                }
            } else {
                // There was some error with the connection so check the message
                print_r($response->status()->message() . "\n");
            }
        }
    }
    /**
     * Only consult is PENDING session of pay
     *
     * @param [type] $codeunique
     * @return boolean
     */
    public function estatusPayPending($codeunique): bool
    {
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $orderPayData = OrderPayData::where('order_id', '=', $order[0]["id"])->get();
        if (!$orderPayData->isEmpty()) {
            $placetopay = $this->createObject();
            $response = $placetopay->query($orderPayData[0]['request_id']);
            $this->status = $response->status()->status();
            if ($response->isSuccessful() && $this->status == 'PENDING') {
                $this->processUrl = $orderPayData[0]['proccess_url'];
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Return array with data order for Process Pay
     *
     * @param [type] $codeunique
     * @return array
     */
    public function createDataForProcessPay($codeunique): array
    {
        $order = Order::where('codebuy', '=', $codeunique)->get();
        $orderPayerBuyer = $this->createPayerBuyer($order);
        $orderShipping = $this->createUserShipping($order);
        $orderItems = $this->getItemsOrder($order[0]["id"]);
        return [
            'locale' => 'es_CO',
            'payer' => $orderPayerBuyer,
            'buyer' => $orderPayerBuyer,
            'payment' => [
                'reference' => $codeunique,
                'description' => 'Thank you for your purchase.',
                'amount' => [
                    'taxes' => [],
                    'details' => [
                        [
                            'kind' => 'shipping',
                            'amount' => 0,
                        ],
                        [
                            'kind' => 'tip',
                            'amount' => 0,
                        ],
                        [
                            'kind' => 'subtotal',
                            'amount' => (float)$order[0]["total"],
                        ],
                    ],
                    'currency' => 'USD',
                    'total' => (float)$order[0]["total"],
                ],
                'items' => $orderItems,
                'shipping' => $orderShipping,
                'allowPartial' => false,
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.86 Safari/537.36',
            'returnUrl' => env('APP_URL') . '/responseProcessPay?codeunique=' . $codeunique,
            'ipAddress' => env('APP_IP'),
            'skipResult' => false,
            'noBuyerFill' => false,
            'captureAddress' => false,
            'paymentMethod' => null,
        ];
    }
}

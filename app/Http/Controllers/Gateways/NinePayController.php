<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class NinePayController extends Controller
{
    protected $apiUrl;
    protected $partnerCode;
    protected $secretKey;

    public function __construct()
    {
        $this->apiUrl = env('9PAY_END_POINT');
        $this->merchantKey = env('9PAY_MERCHANT_KEY');
        $this->secretKey = env('9PAY_SECRET_KEY');
    }

    public function createPayment($orderId, $amount, $gateway)
    {
        $description = 'Thanh toán khóa học';
        $time = time();
        $params = [
            'merchantKey' => $this->merchantKey,
            'time' => $time,
            'invoice_no' => $orderId,
            'amount' => $amount,
            'description' => $description,
            'method' => $gateway,
            'return_url' => route('payment.notify'),
        ];
        $message = [
            'time' => $time,
            'url' => $this->apiUrl . '/payments/create',
            'method' => 'POST',
            'data' => $params,
        ];
        $signature = hash_hmac('sha256', json_encode($message), $this->secretKey);
        $httpData = [
            'baseEncode' => base64_encode(json_encode($params, JSON_UNESCAPED_UNICODE)),
            'signature' => $signature,
        ];
        $queryParams = http_build_query($httpData);
        $redirectUrl = $this->apiUrl . '/portal?' . $queryParams;

       return redirect($redirectUrl);
    }

    protected function generateSignature($params)
    {
        ksort($params);
        $query = http_build_query($params);
        return hash_hmac('sha256', $query, $this->secretKey);
    }
}

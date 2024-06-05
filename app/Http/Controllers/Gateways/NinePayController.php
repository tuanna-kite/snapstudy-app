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
        $this->secretKey = env('9PAY_MERCHANT_SECRET_KEY');
    }

    public function createPayment($orderId, $amount, $gateway)
    {
        $description = 'Thanh toán khóa học';
        $time = time();
        $params = [
            'merchantKey' => $this->merchantKey,
            'time' => $time,
            'invoice_no' => $time,
            'amount' => $amount,
            'description' => $description,
            'method' => $gateway,
            'return_url' => route('ninepay.result'),
            'back_url' => route('home'),
        ];

        $stringToSign = "POST\n" . $this->apiUrl . "/payments/create\n" . $time . "\n" . http_build_query($params);

        // Tạo chữ ký
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true) );
//        $signature =  base64_encode(HMACSHA256());
        $httpData = [
            'baseEncode' => base64_encode(json_encode($params, JSON_UNESCAPED_UNICODE)),
            'signature' => $signature,
        ];

        $redirectUrl = $this->apiUrl . '/portal?' . http_build_query($httpData);
        header("Location: " . $redirectUrl);
        exit();
    }

    protected function generateSignature($params)
    {
        ksort($params);
        $query = http_build_query($params);
        return hash_hmac('sha256', $query, $this->secretKey);
    }
}

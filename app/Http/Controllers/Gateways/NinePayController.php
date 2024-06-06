<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class NinePayController extends Controller
{
    protected $apiUrl;
    protected $merchantKey;
    protected $secretKey;
    protected $checkSum;

    public function __construct()
    {
        $this->apiUrl = env('9PAY_END_POINT');
        $this->merchantKey = env('9PAY_MERCHANT_KEY');
        $this->secretKey = env('9PAY_SECRET_KEY');
        $this->checkSum = env('9PAY_KEY_CHECKSUM');
    }

    public function createPayment($orderId, $amount, $gateway)
    {
        $description = 'Thanh toán khóa học';
        $time = time();
        $params = [
            'amount' => round($amount),
            'back_url' => route('home'),
            'description' => $description,
            'invoice_no' => $orderId,
            'merchantKey' => $this->merchantKey,
            'method' => $gateway,
            'return_url' => route('ninepay.result'),
            'time' => $time,
        ];

        $stringToSign = "POST\n" . $this->apiUrl . "/payments/create\n" . $time . "\n" . http_build_query($params);

        // Tạo chữ ký
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));
        $httpData = [
            'baseEncode' => base64_encode(json_encode($params, JSON_UNESCAPED_UNICODE)),
            'signature' => $signature,
        ];

        $redirectUrl = $this->apiUrl . '/portal?' . http_build_query($httpData);
        header("Location: " . $redirectUrl);
        exit();
    }

    public function createPaymentAccount($amount, $gateway) {
        $description = 'Nạp Spoint';
        $time = time();
        $params = [
            'amount' => round($amount),
            'back_url' => route('home'),
            'description' => $description,
            'invoice_no' => $time,
            'merchantKey' => $this->merchantKey,
            'method' => $gateway,
            'return_url' => route('9pay.result'),
            'time' => $time,
        ];

        $stringToSign = "POST\n" . $this->apiUrl . "/payments/create\n" . $time . "\n" . http_build_query($params);

        // Tạo chữ ký
        $signature = base64_encode(hash_hmac('sha256', $stringToSign, $this->secretKey, true));
        $httpData = [
            'baseEncode' => base64_encode(json_encode($params, JSON_UNESCAPED_UNICODE)),
            'signature' => $signature,
        ];

        $redirectUrl = $this->apiUrl . '/portal?' . http_build_query($httpData);
        header("Location: " . $redirectUrl);
        exit();
    }
}

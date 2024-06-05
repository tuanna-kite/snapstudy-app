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

    public function createPayment($orderId, $amount, $description)
    {
        $params = [
            'merchantKey' => $this->merchantKey,
            'time' => time(),
            'invoice_no' => $orderId,
            'amount' => $amount,
            'description' => $description,
            'return_url' => route('payment.notify'),
        ];

        $params['signature'] = $this->generateSignature($params);

        $response = Http::post($this->apiUrl . '/payment/create', $params);

        return $response->json();
    }

    public function createDomesticCardPayment($orderId, $amount, $description, $bankCode)
    {
        $params = [
            'merchantKey' => $this->merchantKey,
            'time' => time(),
            'invoice_no' => $orderId,
            'amount' => $amount,
            'description' => $description,
            'return_url' => route('payment.notify'),
        ];

        $params['signature'] = $this->generateSignature($params);

        $response = Http::post($this->apiUrl . '/domestic-card/payment/create', $params);

        return $response->json();
    }

    public function createVisaCardPayment($orderId, $amount, $description)
    {
        $params = [
            'merchantKey' => $this->merchantKey,
            'time' => time(),
            'invoice_no' => $orderId,
            'amount' => $amount,
            'description' => $description,
            'return_url' => route('payment.notify'),
        ];

        $params['signature'] = $this->generateSignature($params);

        $response = Http::post($this->apiUrl . '/visa-card/payment/create', $params);

        return $response->json();
    }

    protected function generateSignature($params)
    {
        ksort($params);
        $query = http_build_query($params);
        return hash_hmac('sha256', $query, $this->secretKey);
    }
}

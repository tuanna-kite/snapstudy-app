<?php

namespace App\Http\Controllers\Gateways;

use App\Http\Controllers\Controller;

class VnpayController extends Controller
{
    /**
     * render payment link
     *
     * @param
     * $transactionId id của giao dịch
     * $amount số tiền cần giao dịch
     * $returnUrl Đường dẫn nhận kết quả
     * $startTime Thời gian bắt đầu
     * $expireTime Thời gian kết thúc
     * $description Thêm mô tả
     */
    public function renderPaymentLink($orderId, $amount)
    {
        // config
        $vnpTmnCode = env("VNP_TMN_CODE");
        $vnpHashSecret = env("VNP_HASH_SECRET");
        $vnpUrl = env("VNP_URL");
        $vnpLocale = "vn";
        $vnpIpAddr = $_SERVER['REMOTE_ADDR'];

        $time = time();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnpTmnCode,
            "vnp_Amount" => $amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnpIpAddr,
            "vnp_Locale" => $vnpLocale,
            "vnp_OrderInfo" => 'Thanh toan khoa hoc',
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => route('ninepay.result'),
            "vnp_TxnRef" => $orderId,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpUrl = $vnpUrl . "?" . $query;

        if (isset($vnpHashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashData, $vnpHashSecret);
            $vnpUrl .= 'vnp_SecureHash=' . $vnpSecureHash;

            header("Location: " . $vnpUrl);
            exit();
        }


        return false;
    }
}

<?php

namespace App\Services;

use App\Models\Frontend\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

class PaysantsPayService
{
    public const MERCHANT = 'Merchant-Code';
    public const PAY_INTENT_H5 = '/collect/v1/order/intent';

    protected string $merchantId;
    protected string $appId;
    protected string $signKey;
    protected string $domain;
    protected string $checkoutDomain;
    protected string $notifyUrl;
    protected string $frontCallbackUrl;
    protected string $payType;
    protected Client $client;

    public function __construct(?array $config = null)
    {
        $config = $config ?? config('services.paysantspay', []);
        $this->merchantId = $config['merchant_id'] ?? '';
        $this->appId = $config['app_id'] ?? '';
        $this->signKey = $config['sign_key'] ?? '';
        $this->domain = rtrim($config['domain'] ?? 'https://api.upayhub.com/gateway', '/');
        $this->checkoutDomain = rtrim($config['checkout_domain'] ?? 'https://checkout.porosmall.in', '/');
        $this->notifyUrl = $config['notify_url'] ?? '';
        $this->frontCallbackUrl = $config['front_callback_url'] ?? '';
        $this->payType = $config['pay_type'] ?? 'LINK';
        $this->client = new Client(['verify' => false]);
    }

    /**
     * Create payment intent and return payment link / QR for the order.
     *
     * @return array{success: bool, message?: string, data?: array{paymentLink: string, qrcode?: string}, channelTradeNo?: string}
     */
    public function createPayment(Order $order): array
    {
        $total = (float) ($order->total_price + $order->shipping_cost - ($order->coupon_discount ?? 0));

        $phone = $order->shipping_mobile ?? $order->user_mobile ?? '';
        if ($phone !== '' && (!str_starts_with($phone, '91') || strlen($phone) === 10)) {
            $phone = '91' . ltrim($phone, '91');
        }
        if ($phone === '91') {
            $phone = '';
        }

        // Gateway requires outTradeNo: 6–32 chars, letters and numbers only
        $outTradeNo = 'O' . str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);

        // Reference always uses CASHIER; gateway returns both cashierUrl and intent in same response
        $indiaReq = [
            'version' => 'V1',
            'appId' => $this->appId,
            'outTradeNo' => $outTradeNo,
            'integrate' => 'CASHIER',
            'currency' => 'INR',
            'amount' => number_format($total, 2, '.', ''),
            'paymentInfo' => ['methodType' => 'UPI'],
            'goodsInfo' => ['goodsId' => '1001', 'goodsName' => 'clothing'],
            'userInfo' => [
                'id' => Str::random(5) . $order->user_id,
                'name' => $order->shipping_name ?? $order->user_first_name ?? 'Customer',
                'email' => $order->user_email ?? '',
                'mobile' => $phone,
            ],
            'configInfo' => [
                'cashierGateway' => rtrim($this->checkoutDomain, '/') . '/',
            ],
            'frontCallbackUrl' => $this->frontCallbackUrl . (str_contains($this->frontCallbackUrl, '?') ? '&' : '?') . 'order_no=' . urlencode($outTradeNo),
            'notifyUrl' => $this->notifyUrl,
        ];
        $indiaReq['userInfo']['mobile'] = $phone;
        $indiaReq['sign'] = $this->createSign($indiaReq, $this->signKey);

        $header = [
            'Content-Type' => 'application/json',
            self::MERCHANT => $this->merchantId,
        ];

        info('PaysantsPay order request', ['order_id' => $order->id, 'payload' => $indiaReq]);

        try {
            $response = $this->client->request('POST', $this->domain . self::PAY_INTENT_H5, [
                'json' => $indiaReq,
                'timeout' => 10,
                'headers' => $header,
            ]);
        } catch (GuzzleException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

        $content = $response->getBody()->getContents();
        info('PaysantsPay API response', ['order_id' => $order->id, 'raw' => $content]);
        $result = json_decode($content, true);

        if (empty($result) || !isset($result['data'])) {
            $apiMessage = $result['message'] ?? 'Invalid gateway response';
            if (stripos($apiMessage, 'no channel') !== false || stripos($apiMessage, 'channel') !== false) {
                $apiMessage = 'Payment channel is not available. Please enable UPI for your merchant in the UpayHub/PaysantsPay dashboard. Gateway: ' . $apiMessage;
            }
            return [
                'success' => false,
                'message' => $apiMessage,
            ];
        }

        $qrcode = '';
        $intent = $result['data']['intent'] ?? $result['data']['upiIntent'] ?? $result['data']['qrIntent'] ?? $result['data']['intentUrl'] ?? '';
        if ($this->payType === 'INTENT' && $intent !== '' && is_string($intent)) {
            $qrcode = $this->generateQrCodeFromIntent($intent);
        }
        if ($this->payType === 'INTENT' && $qrcode === '' && $intent === '' && !empty($result['data'])) {
            \Log::warning('PaysantsPay: INTENT requested but no intent in response', ['data_keys' => array_keys($result['data']), 'order_id' => $order->id]);
        }

        return [
            'success' => (int) ($result['status'] ?? 0) === 200,
            'message' => '',
            'channelTradeNo' => $result['data']['platTradeNo'] ?? '',
            'data' => [
                'paymentLink' => $result['data']['cashierUrl'] ?? '',
                'qrcode' => $qrcode,
            ],
        ];
    }

    /**
     * Convert UPI intent URL/string to QR code using Laravel package (simplesoftwareio/simple-qrcode).
     * Uses SVG format so it works without the Imagick extension (PNG would require Imagick).
     */
    protected function generateQrCodeFromIntent(string $intentUrl): string
    {
        if (!app()->bound('qrcode')) {
            \Log::warning('PaysantsPay: qrcode package not registered. Run: composer require simplesoftwareio/simple-qrcode');
            return '';
        }
        try {
            $generator = app('qrcode');
            $img = $generator->format('svg')->size(200)->generate($intentUrl);
            $raw = $img instanceof \Illuminate\Support\HtmlString ? (string) $img : $img;
            return 'data:image/svg+xml;base64,' . base64_encode($raw);
        } catch (\Throwable $e) {
            \Log::warning('PaysantsPay: QR generation failed', ['message' => $e->getMessage()]);
            return '';
        }
    }

    /**
     * Verify and process notify callback from gateway.
     *
     * @return array{success: bool, message: string, data: array}
     */
    public function handleNotify(array $notifyReq): array
    {
        $notifyRes = [
            'success' => true,
            'message' => '',
            'data' => [],
        ];

        if (!$this->verifySign($notifyReq, $this->signKey)) {
            return [
                'success' => false,
                'message' => 'sign error',
                'data' => [],
            ];
        }

        $status = strtolower($notifyReq['payStatus'] ?? '');
        if ($status === 'success') {
            $notifyRes['data']['status'] = 'success';
        } elseif ($status === 'failure') {
            $notifyRes['data']['status'] = 'failure';
        } elseif ($status === 'refund') {
            $notifyRes['data']['status'] = 'refund';
        } else {
            $notifyRes['data']['status'] = 'unpaid';
        }

        return $notifyRes;
    }

    public function createSign(array $params, string $secret): string
    {
        $this->sortRecursion($params);
        $signstr = '';

        foreach ($params as $k => $v) {
            if ($v === null) {
                continue;
            }
            if (is_array($v)) {
                $signstr .= $k . '=';
                foreach ($v as $k2 => $v2) {
                    $signstr .= $k2 . '=' . $v2 . '&';
                }
            } else {
                $signstr .= $k . '=' . $v . '&';
            }
        }
        $signstr .= 'key=' . $secret;
        info('PaysantsPay sign md5 str: ' . $signstr);
        return strtoupper(md5($signstr));
    }

    protected function sortRecursion(array &$arr): void
    {
        ksort($arr);
        foreach ($arr as $key => &$value) {
            if (is_array($value)) {
                $this->sortRecursion($value);
            }
        }
    }

    public function verifySign(array $params, string $secret): bool
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value) {
            if ($value === null || $key === 'sign') {
                continue;
            }
            if (in_array($key, ['payAmount', 'serviceFee', 'amount'])) {
                $value = number_format((float) $value, 2, '.', '');
            }
            $str .= $key . '=' . $value . '&';
        }
        $str .= 'key=' . $secret;
        $sign = $params['sign'] ?? '';
        info('PaysantsPay verifysign str: ' . $str);
        return $sign === strtoupper(md5($str));
    }
}

<?php

namespace App\Services;

use App\Models\Frontend\Order;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Paydhara payment gateway.
 *
 * Auth is two-step: getAccessToken exchanges the apikey/secretkey pair for a
 * short-lived bearer token (~1h), which every other call must also carry
 * alongside the same key headers.
 *
 * The API reports failures with `success: true` and only distinguishes the
 * outcome through `status` / `status_code`, so never branch on `success`.
 */
class PaydharaService
{
    private const TOKEN_CACHE_KEY = 'paydhara.access_token';

    protected string $apiKey;
    protected string $secretKey;
    protected string $baseUrl;
    protected int $timeout;
    protected Client $client;

    public function __construct(?array $config = null)
    {
        $config = $config ?? config('services.paydhara', []);
        $this->apiKey    = (string) ($config['api_key'] ?? '');
        $this->secretKey = (string) ($config['secret_key'] ?? '');
        $this->baseUrl   = rtrim((string) ($config['base_url'] ?? 'https://api.paydhara.com/api/v1'), '/');
        $this->timeout   = (int) ($config['timeout'] ?? 30);
        $this->client    = new Client();
    }

    public function isConfigured(): bool
    {
        return $this->apiKey !== '' && $this->secretKey !== '';
    }

    /**
     * Build the unique merchant reference we send as `refid`.
     * Kept alphanumeric and short because the gateway echoes it back verbatim.
     */
    public static function buildRefId(int $orderId): string
    {
        return 'BM' . $orderId . strtoupper(Str::random(6));
    }

    /**
     * Fetch (and cache) the bearer token.
     *
     * The token is cached until 60s before the server-reported expiry so a
     * request never races the expiry boundary.
     */
    public function getAccessToken(bool $forceRefresh = false): ?string
    {
        if (!$forceRefresh) {
            $cached = Cache::get(self::TOKEN_CACHE_KEY);
            if (is_string($cached) && $cached !== '') {
                return $cached;
            }
        }

        try {
            $response = $this->client->request('POST', $this->baseUrl . '/getAccessToken', [
                'headers' => [
                    'apikey'    => $this->apiKey,
                    'secretkey' => $this->secretKey,
                    'Accept'    => 'application/json',
                ],
                'timeout' => $this->timeout,
            ]);
        } catch (GuzzleException $e) {
            Log::error('Paydhara getAccessToken failed', ['message' => $e->getMessage()]);
            return null;
        }

        $result = json_decode((string) $response->getBody(), true);

        if (empty($result['token'])) {
            Log::error('Paydhara getAccessToken returned no token', ['response' => $result]);
            return null;
        }

        $token = (string) $result['token'];
        $ttl = 3300; // sane default if the API omits/!parses expires_in
        if (!empty($result['expires_in'])) {
            $expiresAt = strtotime((string) $result['expires_in']);
            if ($expiresAt) {
                $ttl = max(60, $expiresAt - time() - 60);
            }
        }
        Cache::put(self::TOKEN_CACHE_KEY, $token, $ttl);

        return $token;
    }

    /**
     * Authenticated JSON request, retrying once on 401 with a fresh token.
     *
     * @return array{ok: bool, status: int, body: array, error: ?string}
     */
    protected function request(string $path, array $payload, bool $retryOnAuthFailure = true): array
    {
        $token = $this->getAccessToken();
        if ($token === null) {
            return ['ok' => false, 'status' => 0, 'body' => [], 'error' => 'Unable to authenticate with the payment gateway.'];
        }

        try {
            $response = $this->client->request('POST', $this->baseUrl . $path, [
                'headers' => [
                    'apikey'        => $this->apiKey,
                    'secretkey'     => $this->secretKey,
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json'        => $payload,
                'timeout'     => $this->timeout,
                'http_errors' => false,
            ]);
        } catch (GuzzleException $e) {
            Log::error('Paydhara request failed', ['path' => $path, 'message' => $e->getMessage()]);
            return ['ok' => false, 'status' => 0, 'body' => [], 'error' => $e->getMessage()];
        }

        $status = $response->getStatusCode();
        $raw = (string) $response->getBody();
        $body = json_decode($raw, true) ?: [];

        // An expired token surfaces as 401; refresh once and replay.
        if ($status === 401 && $retryOnAuthFailure) {
            Cache::forget(self::TOKEN_CACHE_KEY);
            $this->getAccessToken(true);
            return $this->request($path, $payload, false);
        }

        Log::info('Paydhara response', ['path' => $path, 'http' => $status, 'body' => $body]);

        return ['ok' => $status >= 200 && $status < 300, 'status' => $status, 'body' => $body, 'error' => null];
    }

    /**
     * Create a payment order and return the hosted payment link.
     *
     * @return array{success: bool, message: string, refid: ?string, payment_link: ?string, transaction_id: ?string, reference_id: ?string}
     */
    public function createOrder(Order $order, string $refId): array
    {
        $amount = self::orderAmount($order);

        if ($amount <= 0) {
            return self::failure('Order amount must be greater than zero.', $refId);
        }

        $payload = [
            'refid'      => $refId,
            'payer_name' => (string) ($order->shipping_name ?: $order->user_first_name ?: 'Customer'),
            'amount'     => round($amount, 2),
            'email'      => (string) ($order->user_email ?: ''),
            'mobile'     => self::normaliseMobile((string) ($order->shipping_mobile ?: $order->user_mobile)),
        ];

        $res = $this->request('/create-pgorder', $payload);
        $body = $res['body'];

        if (!$res['ok'] && empty($body)) {
            return self::failure($res['error'] ?: 'Could not reach the payment gateway.', $refId);
        }

        // `success` is true even for declined orders - the outcome lives in `status`.
        $status = strtolower((string) ($body['status'] ?? ''));
        $statusCode = (int) ($body['status_code'] ?? 0);
        $link = $body['data']['payment_link'] ?? null;

        if ($status !== 'success' || $statusCode >= 400 || empty($link)) {
            return self::failure(
                (string) ($body['message'] ?? 'The payment gateway rejected this order.'),
                $refId
            );
        }

        return [
            'success'        => true,
            'message'        => (string) ($body['message'] ?? ''),
            'refid'          => $refId,
            'payment_link'   => (string) $link,
            'transaction_id' => isset($body['data']['transaction_id']) ? (string) $body['data']['transaction_id'] : null,
            'reference_id'   => isset($body['data']['reference_id']) ? (string) $body['data']['reference_id'] : null,
        ];
    }

    /**
     * Authoritative status lookup.
     *
     * The webhook payload is undocumented and unsigned, so this call - not the
     * webhook body - decides whether an order is paid.
     *
     * @return array{state: string, message: string, utr: ?string, transaction_id: ?string, raw: array}
     */
    public function transactionStatus(string $refId): array
    {
        $res = $this->request('/transaction-status', ['refid' => $refId]);
        $body = $res['body'];

        $status = strtolower((string) ($body['status'] ?? ''));
        $state = in_array($status, ['success', 'failed', 'pending'], true) ? $status : 'unknown';

        return [
            'state'          => $state,
            'message'        => (string) ($body['message'] ?? ''),
            'utr'            => isset($body['data']['utr']) && $body['data']['utr'] !== 'null'
                ? (string) $body['data']['utr'] : null,
            'transaction_id' => isset($body['data']['transaction_id']) ? (string) $body['data']['transaction_id'] : null,
            'raw'            => $body,
        ];
    }

    /** Payable total for an order, matching what the rest of checkout charges. */
    public static function orderAmount(Order $order): float
    {
        return round(
            (float) $order->total_price + (float) $order->shipping_cost - (float) ($order->coupon_discount ?? 0),
            2
        );
    }

    /** Gateway expects a bare 10-digit Indian mobile number. */
    private static function normaliseMobile(string $mobile): string
    {
        $digits = preg_replace('/\D+/', '', $mobile) ?? '';
        if (strlen($digits) > 10) {
            $digits = substr($digits, -10);
        }
        return $digits;
    }

    private static function failure(string $message, string $refId): array
    {
        return [
            'success'        => false,
            'message'        => $message,
            'refid'          => $refId,
            'payment_link'   => null,
            'transaction_id' => null,
            'reference_id'   => null,
        ];
    }
}

<?php

namespace App\Console\Commands;

use App\Services\PaydharaService;
use Illuminate\Console\Command;

/**
 * Connectivity check for the Paydhara gateway.
 *
 * Paydhara refuses any call from a non-whitelisted IP, so this reports the
 * outbound IP alongside the result to make whitelisting requests easy.
 */
class PaydharaCheck extends Command
{
    protected $signature = 'paydhara:check {--status= : Look up a refid instead of only authenticating}';

    protected $description = 'Verify Paydhara credentials, IP whitelisting and connectivity';

    public function handle(): int
    {
        $service = new PaydharaService();

        $this->line('');
        $this->line('  Base URL : ' . config('services.paydhara.base_url'));
        $this->line('  API key  : ' . $this->mask((string) config('services.paydhara.api_key')));
        $this->line('  Secret   : ' . $this->mask((string) config('services.paydhara.secret_key')));
        $this->line('  Outbound IP : ' . $this->outboundIp());
        $this->line('');

        if (!$service->isConfigured()) {
            $this->error('  Credentials are missing. Set PAYDHARA_API_KEY and PAYDHARA_SECRET_KEY in .env');
            return self::FAILURE;
        }

        $token = $service->getAccessToken(true);

        if ($token === null) {
            $this->error('  Authentication FAILED.');
            $this->line('  Most likely this server\'s IP is not whitelisted with Paydhara.');
            $this->line('  Check storage/logs/laravel.log for the gateway\'s exact message.');
            return self::FAILURE;
        }

        $this->info('  Authentication OK - token acquired.');

        if ($refId = $this->option('status')) {
            $result = $service->transactionStatus($refId);
            $this->line('');
            $this->line('  refid  : ' . $refId);
            $this->line('  state  : ' . $result['state']);
            $this->line('  message: ' . $result['message']);
            $this->line('  utr    : ' . ($result['utr'] ?? '-'));
        }

        return self::SUCCESS;
    }

    private function mask(string $value): string
    {
        if ($value === '') {
            return '(empty)';
        }
        return strlen($value) <= 8
            ? str_repeat('*', strlen($value))
            : substr($value, 0, 4) . str_repeat('*', strlen($value) - 8) . substr($value, -4);
    }

    private function outboundIp(): string
    {
        $ctx = stream_context_create(['http' => ['timeout' => 5]]);
        $ip = @file_get_contents('https://api.ipify.org', false, $ctx);
        return $ip !== false && $ip !== '' ? trim($ip) : '(could not determine)';
    }
}

<?php

namespace Database\Seeders;

use App\Models\Backend\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Credentials come from .env, never hard-coded. The previous version
        // shipped the theme's demo Stripe/PayPal/Razorpay keys inline, which
        // GitHub's push protection (correctly) refuses to accept.
        $data = [
            ['Paypal', json_encode([
                'CLIENT_ID' => env('PAYPAL_CLIENT_ID', ''),
                'CLIENT_SECRET' => env('PAYPAL_CLIENT_SECRET', ''),
                'MODE' => env('PAYPAL_MODE', 'sandbox'),
            ]), 0],
            ['Stripe', json_encode([
                'KEY' => env('STRIPE_KEY', ''),
                'SECRET' => env('STRIPE_SECRET', ''),
            ]), 0],
            ['Razorpay', json_encode([
                'KEY_ID' => env('RAZORPAY_KEY_ID', ''),
                'KEY_SECRET' => env('RAZORPAY_KEY_SECRET', ''),
            ]), 0],
        ];

        foreach ($data as $d) {
            PaymentGateway::query()->updateOrCreate(
                ['name' => $d[0]],
                ['configuration' => $d[1], 'status' => $d[2]]
            );
        }

        // Paydhara (online payment)
        PaymentGateway::query()->firstOrCreate(
            ['name' => 'Paydhara'],
            [
                'configuration' => json_encode([
                    'api_key' => env('PAYDHARA_API_KEY', ''),
                    'secret_key' => env('PAYDHARA_SECRET_KEY', ''),
                    'base_url' => env('PAYDHARA_BASE_URL', 'https://api.paydhara.com/api/v1'),
                ]),
                'status' => 1,
            ]
        );
    }
}

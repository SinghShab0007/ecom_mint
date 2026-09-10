<?php

namespace App\Models\Frontend;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment which has access
     * credentials context. This can be used invoke PayPal API's provided the
     * credentials have the access to do so.
     */
    public static function client(): PayPalHttpClient
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Setting up and Returns PayPal SDK environment with PayPal Access credentials.
     * For demo purpose, we are using SandboxEnvironment. In production this will be
     * ProductionEnvironment.
     */
    public static function environment()
    {
        $payment = PaymentGateway::query()->where('name','paypal')->first();
        $configurations = json_decode($payment->configuration);

        if($configurations->MODE == 'sandbox'){
            return new SandboxEnvironment($configurations->CLIENT_ID,$configurations->CLIENT_SECRET);
        }else{
            return new ProductionEnvironment($configurations->CLIENT_ID,$configurations->CLIENT_SECRET);
        }
    }
}

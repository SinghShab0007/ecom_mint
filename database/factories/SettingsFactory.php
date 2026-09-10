<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Settings::class, function (Faker $faker) {
    return [
        'name' => 'Maan',
        'logo' => 'assets/images/logo-icon.png',
        'favicon' =>'assets/images/favicon.ico',
        'vat' => $faker->numberBetween(0,10),
        'currency_id' => 17,
        'time_zone' => 'Asia/Kolkata',
        'barcode_type' => 'C39',
    ];
});

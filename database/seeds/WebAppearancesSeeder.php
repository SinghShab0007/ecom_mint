<?php


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebAppearancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('web_appearances')->insert(
            [
                'id' => 1,
                'website_name' => 'Online Parks',
                'logo' => 'logo.png',
                'favicon' => 'favicon.jpg',
                'backend_logo' => 'backend_logo.png',
                'meta_title' => 'Online Park',
                'meta_desc' => 'The Largest online shopping portal',
                'keywords' => 'Online Park',
                'website_base_color' => '#EBsdsd',
                'website_base_hover_color' => '#EBsdsd',
                'cookies_agreement_desc' => 'Online Park',
                'is_show_cookies_agreement' => 0,
                'hotline_number' => '01854432212',
                'email' => 'support@mybazar.com',
                'city' => 'India',
                'post_code' => '1000',
                'country' => 'BANGLADESH',
                'currency_id' => 13,
                'about_us' => 'The new hero pieces bring instant fashion credibility. Bright florals clash with camouflage. The new hero pieces bring instant fashion credibility. Bright florals clash with camouflage.',
                'get_in_touch' => 'Contact us, India',
                'facebook_link' => 'https://www.facebook.com/MaanTheme',
                'twitter_link' => 'https://twitter.com/',
                'pinterest_link' => 'https://www.pinterest.com/',
                'instagram_link' => 'https://www.instagram.com/',
                'created_at' => '2021-08-20 17:38:20',
                'updated_at' => '2021-11-08 09:21:39'
            ]
        );

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EcommerceFaqSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $appName = config('app.name', 'BillMintMall');

        DB::transaction(function () use ($now, $appName) {
            DB::table('faqs')->delete();

            $categoryId = DB::table('faq_categories')->where('id', 1)->exists() ? 1 : null;
            if ($categoryId) {
                DB::table('faq_categories')->where('id', 1)->update([
                    'name' => 'General',
                    'slug' => 'general',
                    'order' => 1,
                    'is_active' => 1,
                    'deleted_at' => null,
                    'updated_at' => $now,
                ]);
            } else {
                $categoryId = DB::table('faq_categories')->insertGetId([
                    'name' => 'General',
                    'slug' => 'general',
                    'order' => 1,
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $subCategoryId = DB::table('faq_sub_categories')->where('id', 1)->exists() ? 1 : null;
            if ($subCategoryId) {
                DB::table('faq_sub_categories')->where('id', 1)->update([
                    'faq_category_id' => $categoryId,
                    'name' => 'Common Questions',
                    'slug' => 'common-questions',
                    'order' => 1,
                    'is_active' => 1,
                    'deleted_at' => null,
                    'updated_at' => $now,
                ]);
            } else {
                $subCategoryId = DB::table('faq_sub_categories')->insertGetId([
                    'faq_category_id' => $categoryId,
                    'name' => 'Common Questions',
                    'slug' => 'common-questions',
                    'order' => 1,
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $faqs = [
                [
                    'question' => 'How do I place an order on ' . $appName . '?',
                    'answer' => 'Browse our products, add the items you want to your cart, and proceed to checkout. You can pay using any of our supported payment methods. Once your order is placed, you will receive a confirmation email with your order details.',
                ],
                [
                    'question' => 'How can I track my order?',
                    'answer' => 'After your order is shipped, you will receive a tracking ID by email. You can also track your order anytime from your account by going to "My Orders" on the customer dashboard.',
                ],
                [
                    'question' => 'How long does delivery take?',
                    'answer' => 'Standard delivery typically takes 3-7 business days, depending on your location. Express delivery (where available) usually arrives within 1-3 business days. Exact delivery times are shown on each product page and at checkout.',
                ],
                [
                    'question' => 'What payment methods do you accept?',
                    'answer' => 'We accept Credit/Debit Cards, UPI, Net Banking, Wallets, and Cash on Delivery (COD) for eligible orders. All online payments are processed through secure payment gateways.',
                ],
                [
                    'question' => 'What is your return and refund policy?',
                    'answer' => 'Most products can be returned within 7 days of delivery if they are unused, in original packaging, and in resalable condition. Refunds are processed within 5-7 business days after we receive and inspect the returned item. Some categories (like personal care or innerwear) may not be eligible for return.',
                ],
                [
                    'question' => 'How do I cancel my order?',
                    'answer' => 'You can cancel your order before it is shipped from your account under "My Orders". Once an order has been shipped, it cannot be cancelled but you may return it after delivery as per our return policy.',
                ],
                [
                    'question' => 'How do I create an account?',
                    'answer' => 'Click on "Customer Login" at the top of the page and choose "Register". Fill in your name, mobile, email, and password. You will receive a 6-digit OTP on your email to verify your account, and you will be logged in automatically after verification.',
                ],
                [
                    'question' => 'I forgot my password. How do I reset it?',
                    'answer' => 'Click "Forgot Password?" on the login page and enter your registered email. You will receive a password reset link by email — open it and follow the instructions to set a new password.',
                ],
                [
                    'question' => 'How do I become a seller on ' . $appName . '?',
                    'answer' => 'Click on "Seller Login" → "Register as Seller" or visit /seller/registration. Fill out your business details (PAN, GSTIN if applicable, address, and shop info) and submit. Our team will review and activate your seller account.',
                ],
                [
                    'question' => 'How can I contact customer support?',
                    'answer' => 'You can reach us by emailing contact@billmintmall.com or calling +91 9211635360. We are available Monday to Saturday, 10 AM to 7 PM IST.',
                ],
            ];

            $rows = [];
            $order = 1;
            foreach ($faqs as $faq) {
                $rows[] = [
                    'faq_category_id' => $categoryId,
                    'faq_sub_category_id' => $subCategoryId,
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'order' => $order++,
                    'slug' => Str::slug($faq['question']),
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            DB::table('faqs')->insert($rows);
        });

        $this->command->info('FAQ table reset and ' . 10 . ' standard e-commerce FAQs inserted.');
    }
}

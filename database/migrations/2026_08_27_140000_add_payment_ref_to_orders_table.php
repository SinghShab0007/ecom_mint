<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentRefToOrdersTable extends Migration
{
    /**
     * The gateway echoes our `refid` back on the webhook and on every status
     * lookup, so it needs to resolve to an order cheaply and unambiguously -
     * hence a real indexed column rather than a probe into the `meta` JSON.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_ref')) {
                $table->string('payment_ref', 64)->nullable()->after('payment_by')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'payment_ref')) {
                $table->dropIndex(['payment_ref']);
                $table->dropColumn('payment_ref');
            }
        });
    }
}

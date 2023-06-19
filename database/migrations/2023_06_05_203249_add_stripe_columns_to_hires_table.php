<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripeColumnsToHiresTable extends Migration
{
    public function up()
    {
        Schema::table('hires', function (Blueprint $table) {
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('hires', function (Blueprint $table) {
            $table->dropColumn('stripe_product_id');
            $table->dropColumn('stripe_price_id');
            $table->dropColumn('stripe_subscription_id');
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('stripe_payment_intent_id');
        });
    }
}

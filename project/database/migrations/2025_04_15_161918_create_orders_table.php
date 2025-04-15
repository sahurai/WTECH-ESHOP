<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->string('guest_email', 100)->nullable();
            $table->timestamp('order_date')->nullable()->useCurrent();
            $table->decimal('total_amount', 10);
            $table->string('status', 50)->nullable()->default('New');
            $table->string('shipping_name')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->string('shipping_country', 100)->nullable();
            $table->string('shipping_method', 100)->nullable();
            $table->string('payment_method', 100)->nullable();
            $table->timestamp('updated_at')->nullable()->useCurrent();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

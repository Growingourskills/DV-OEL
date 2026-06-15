<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 10);
            $table->string('customer_name', 100);
            $table->integer('age');
            $table->string('gender', 10);
            $table->string('city', 50);
            $table->date('registration_date');
            $table->string('order_id', 20)->unique();
            $table->date('order_date');
            $table->string('product_category', 50);
            $table->string('product_name', 100);
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->integer('total_amount');
            $table->string('payment_method', 30);
            $table->string('discount_applied', 5);
            $table->integer('discount_percent');
            $table->integer('satisfaction_score');
            $table->integer('session_duration_min');
            $table->string('device_type', 20);
            $table->integer('num_previous_purchases');

            $table->index('customer_id');
            $table->index('order_date');
            $table->index('product_category');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

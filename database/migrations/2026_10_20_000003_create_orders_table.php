<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('order_code', 20)->unique();
            $table->foreignId('product_id');
            $table->string('customer_name');
            $table->text('address');
            $table->string('phone', 20);
            $table->unsignedInteger('quantity');
            $table->decimal('total_price', 12, 2);
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            // Produk yang sudah dipesan tidak boleh terhapus begitu saja
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

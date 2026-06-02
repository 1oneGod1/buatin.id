<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_code')->unique();
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->string('product_type');
            $table->string('material')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->date('deadline')->nullable();
            $table->string('budget')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference_path')->nullable();
            $table->unsignedInteger('estimated_price')->default(0);
            $table->string('payment_proof_path')->nullable();
            $table->string('payment_status')->default('unpaid');
            $table->string('status')->default('received');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};

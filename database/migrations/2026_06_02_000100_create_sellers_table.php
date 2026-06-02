<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('slug')->unique();
            $table->string('category')->default('Jasa custom');
            $table->string('whatsapp')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('banner_path')->nullable();
            $table->string('qris_path')->nullable();
            $table->string('payment_account')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->boolean('qris_enabled')->default(false);
            $table->json('form_fields')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};

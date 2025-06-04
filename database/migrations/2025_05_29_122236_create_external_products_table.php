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
      Schema::create('external_products', function (Blueprint $table) {
    $table->id();
    $table->integer('external_id')->unique();
    $table->string('name');
    $table->text('description_sale')->nullable();
    $table->string('image_url')->nullable();
    $table->string('brand')->nullable();
    $table->json('default_codes')->nullable();
    $table->json('product_ids')->default(json_encode([])); // تعيين قيمة افتراضية كمصفوفة فارغة
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_products');
    }
};

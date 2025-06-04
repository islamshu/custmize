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
        Schema::create('external_product_sizes', function (Blueprint $table) {
            $table->id(); // الرقم الأساسي
            $table->unsignedBigInteger('color_id'); // ارتباط باللون الذي ينتمي إليه الحجم
            $table->string('name'); // اسم الحجم (Small, Medium, Large, ... إلخ)
            $table->timestamps();

            // علاقة الربط
            $table->foreign('color_id')->references('id')->on('external_product_colors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_product_sizes');
    }
};

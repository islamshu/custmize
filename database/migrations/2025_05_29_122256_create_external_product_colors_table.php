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
        Schema::create('external_product_colors', function (Blueprint $table) {
            $table->id(); // الرقم الأساسي
            $table->unsignedBigInteger('external_product_id'); // ارتباط بالمنتج الرئيسي
            $table->string('name'); // اسم اللون
            $table->string('code')->nullable(); // كود اللون (HEX)
            $table->timestamps();

            // علاقة الربط
            $table->foreign('external_product_id')->references('id')->on('external_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_product_colors');
    }
};

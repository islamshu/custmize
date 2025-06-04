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
        Schema::table('external_products', function (Blueprint $table) {
            $table->string('image')->nullable();
        });

        Schema::table('external_product_colors', function (Blueprint $table) {
            $table->string('front_image')->nullable();
            $table->string('back_image')->nullable();
            $table->string('right_side_image')->nullable();
            $table->string('left_side_image')->nullable();
            $table->string('defult_price')->nullable();
            $table->string('price')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_products', function (Blueprint $table) {
            //
        });
    }
};

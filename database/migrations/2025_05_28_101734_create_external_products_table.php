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
            $table->unsignedBigInteger('external_id'); // ID من المصدر الخارجي
            $table->string('name');
            $table->string('default_code')->nullable();
            $table->text('description')->nullable();
            $table->string('brand_name')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('category_name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('image_url')->nullable();
            $table->string('color')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('configurable')->default(false);
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

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
        Schema::table('products', function (Blueprint $table) {
            $table->string('image');
            $table->foreignId(column: 'type_id')->nullable()->constrained('type_categories')->onDelete('cascade');
            $table->foreignId(column: 'subcategory_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId(column: 'category_id')->nullable()->constrained('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};

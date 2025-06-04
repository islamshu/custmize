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
            $table->json('product_prices')->nullable()->after('product_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_products', function (Blueprint $table) {
            $table->dropColumn('product_prices');
        });
    }
};

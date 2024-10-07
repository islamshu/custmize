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
        Schema::table('sub_categories', function (Blueprint $table) {
            // Add columns
            $table->integer('have_types');
            $table->integer('have_one_image');
            $table->integer('have_two_image');

            $table->dropColumn('attributs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {

            $table->dropColumn([
                'attributs',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('external_products', function (Blueprint $table) {
            $table->json('images')->nullable();
            $table->json('color_options')->nullable();
            $table->json('product_template_attribute_value_ids')->nullable();
            // تأكد إن الأعمدة الجديدة nullable عشان ما تسبب مشاكل
        });
    }

    public function down()
    {
        Schema::table('external_products', function (Blueprint $table) {
            $table->dropColumn(['images', 'color_options', 'product_template_attribute_value_ids']);
        });
    }
};

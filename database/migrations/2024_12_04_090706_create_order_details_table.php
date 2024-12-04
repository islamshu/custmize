<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('product_id');
            $table->string('product_name');
            $table->string('color_id')->nullable();
            $table->string('size_id')->nullable();
            $table->integer('quantity');
            $table->decimal('price_without_size_color', 10, 2);
            $table->decimal('price_for_size_color', 10, 2);
            $table->decimal('full_price', 10, 2);
            $table->text('front_image')->nullable();
            $table->text('back_image')->nullable();
            $table->json('logos')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}

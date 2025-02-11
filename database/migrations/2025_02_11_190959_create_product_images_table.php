<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_detail_id'); // Foreign key to order_details
            $table->json('front_images')->nullable(); // Store front images as JSON
            $table->json('back_images')->nullable();  // Store back images as JSON
            $table->json('right_side')->nullable();  // Store right side images as JSON
            $table->json('left_side')->nullable();    // Store left side images as JSON
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('order_detail_id')
                  ->references('id')
                  ->on('order_details')
                  ->onDelete('cascade'); // Delete images if order_detail is deleted
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_images');
    }
}
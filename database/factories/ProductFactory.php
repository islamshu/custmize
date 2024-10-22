<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 5, 100),  // مثال للسعر
            'created_at' => now(),
            'updated_at' => now(),
            'image' => $this->faker->imageUrl(640, 480, 'products'),  // صورة وهمية
            'type_id' => 1,  // قيمة وهمية
            'subcategory_id' =>2,  // قيمة وهمية
            'category_id' => 11,  // قيمة وهمية
            'guidness_pic' => '["1728908822-men1_blue_back.png","1728908822-men1_blue_front (1).png"]',  // نص وهمي
            'delivery_date' => '8',
        ];
    }
}

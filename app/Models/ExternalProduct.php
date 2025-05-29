<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalProduct extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'default_code',
        'description',
        'brand_id',
        'brand_name',
        'category_id',
        'category_name',
        'image_url',
        'images',
        'color',
        'configurable',
        'parent_id',
        'color_options',
        'product_template_attribute_value_ids',
    ];

    // لو حابب تفسر الأعمدة JSON تلقائي:
    protected $casts = [
        'images' => 'array',
        'color_options' => 'array',
        'product_template_attribute_value_ids' => 'array',
        'configurable' => 'boolean',
    ];
}

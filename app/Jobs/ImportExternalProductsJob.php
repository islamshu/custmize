<?php

namespace App\Jobs;

use App\Models\ExternalProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportExternalProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public function handle(): void
    {
        try {
            $filePath = 'api_dumps/products_api.json';
            $jsonContent = Storage::disk('local')->get($filePath);
            $products = json_decode($jsonContent, true);

            if (empty($products)) {
                Log::warning("ملف JSON فارغ أو غير صالح");
                return;
            }

            // في حال كان JSON منتج واحد فقط
            if (isset($products['id'])) {
                $products = [$products];
            }

            foreach ($products as $product) {
                // معالجة الصور
                $imageUrls = [];
                if (!empty($product['images']) && is_array($product['images'])) {
                    $innerArray = $product['images'][0] ?? [];
                    if (is_array($innerArray)) {
                        foreach ($innerArray as $img) {
                            if (isset($img['image_url'])) {
                                $imageUrls[] = $img['image_url'];
                            }
                        }
                    }
                }

                ExternalProduct::updateOrCreate(
                    ['external_id' => $product['id']],
                    [
                        'name' => $product['name'] ?? null,
                        'default_code' => $product['default_code'] ?? null,
                        'description' => $product['description_sale'] ?? null,
                        'brand_id' => is_array($product['brand_id']) ? ($product['brand_id'][0] ?? null) : null,
                        'brand_name' => is_array($product['brand_id']) ? ($product['brand_id'][1] ?? null) : null,
                        'category_id' => $product['public_categ_ids'][0]['id'] ?? null,
                        'category_name' => $product['public_categ_ids'][0]['name'] ?? null,
                        'image_url' => $product['image_url'] ?? null,
                        'images' => !empty($imageUrls) ? json_encode($imageUrls) : null,
                        'color' => $product['color'] ?? null,
                        'parent_id' => $product['parent_id'] ?? null,
                        'configurable' => $product['configurable'] ?? false,
                    ]
                );
            }

            Log::info("✅ تم استيراد المنتجات بنجاح.");
        } catch (\Exception $e) {
            Log::error("خطأ أثناء استيراد المنتجات: " . $e->getMessage());
        }
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ExternalProduct;
use App\Models\ExternalProductColor;
use App\Models\ExternalProductSize;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProcessExternalProductsImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productIds;

    public function __construct(string $productIds)
    {
        $this->productIds = $productIds;
    }

    public function handle()
    {
        $products = $this->loadJsonFile('uploads/api_dumps/product_api.json');
        if (!$products) return;

        $prices = $this->loadJsonFile('uploads/api_dumps/price_api.json');
        if (!$prices) return;

        $ids = explode(',', $this->productIds);
        $mainProduct = $this->findMainProduct($products, $ids);
        if (!$mainProduct) return;

        $defaultCodes = [];
        $colors = [];
        $productPrices = []; // ✅ New array to hold product ID => price

        foreach ($products as $product) {
            if (!in_array($product['id'], $ids)) continue;

            $defaultCode = $product['default_code'] ?? null;
            if ($defaultCode) {
                $defaultCodes[] = $defaultCode;
            }

            $priceData = $this->findPriceByCode($prices, $defaultCode);

            // ✅ Save the price for each product ID
            if (isset($product['id'])) {
                $productPrices[$product['id']] = $priceData['price'] ?? null;
            }

            $colorName = $this->extractAttribute($product, 'color');
            $sizeName = $this->extractAttribute($product, 'size');

            if ($colorName) {
                if (!isset($colors[$colorName])) {
                    $colors[$colorName] = [
                        'image' => $product['image_url'] ?? null,
                        'sizes' => [],
                    ];
                }

                if ($sizeName) {
                    $colors[$colorName]['sizes'][] = [
                        'name' => $sizeName,
                        'default_code' => $defaultCode,
                        'external_id' => $product['id'],
                        'price' => $priceData['price'] ?? null,
                    ];
                }
            }
        }
        $externalProduct = ExternalProduct::create([
            'external_id' => $mainProduct['id'],
            'name' => $mainProduct['name'],
            'description_sale' => $mainProduct['description_sale'] ?? null,
            'image' => $this->storeImage($mainProduct['image_url'] ?? null),
            'brand' => $mainProduct['brand_id'][1] ?? null,
            'default_codes' => array_unique($defaultCodes),
            'product_ids' => $ids,
            'product_prices' => $productPrices, // Assuming the column exists

        ]);

        Log::info('Product created', [
            'id' => $externalProduct->id,
            'image_url' => $mainProduct['image_url'] ?? null,
            'stored_image' => $externalProduct->image
        ]);

        foreach ($colors as $colorName => $data) {
            $color = ExternalProductColor::create([
                'external_product_id' => $externalProduct->id,
                'name' => $colorName,
                'front_image' => $this->storeImage($data['image']),
            ]);

            $sizes = $data['sizes'] ?? [['name' => 'واحد', 'default_code' => null, 'external_id' => null]];

            foreach ($sizes as $size) {
                ExternalProductSize::create([
                    'color_id' => $color->id,
                    'name' => $size['name'],
                    'default_code' => $size['default_code'],
                    'external_id' => $size['external_id'],
                    'price' => $size['price'] ?? null,
                ]);
            }
        }
        $token = env('TOKEN_TELEGRAM');
        $chatIds = ['1170979150', '908949980'];
        $url = route('external-products.edit', $externalProduct->id);
        $message = ":: تنبيه ::\n"
            . "تم بنجاح استيراد مجموعة المنتجات التي قمت بتحديدها\n"
            . "يمكنك الدخول للرابط لمراجعة المنتجات المستوردة: \n" . $url;

        foreach ($chatIds as $chatId) {
            $telegramUrl = "https://api.telegram.org/bot{$token}/sendMessage";
            $payload = [
                'chat_id' => $chatId,
                'text' => $message,
            ];

            $ch = curl_init($telegramUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                Log::error("Telegram cURL Error: " . curl_error($ch));
            } else {
                Log::info("Message sent to Telegram chat_id: $chatId");
            }

            curl_close($ch);
        }

        Log::info('تم استيراد المنتج بنجاح', ['external_product_id' => $externalProduct->id]);
    }

    // ========== الدوال المساعدة ========== //

    private function loadJsonFile(string $path): ?array
    {
        $fullPath = base_path($path);
        if (!file_exists($fullPath)) {
            Log::error("File not found: {$path}");
            return null;
        }

        $data = json_decode(file_get_contents($fullPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Invalid JSON: ' . json_last_error_msg());
            return null;
        }

        return is_array($data) ? $data : null;
    }

    private function findMainProduct(array $products, array $ids): ?array
    {
        foreach ($products as $product) {
            if (in_array($product['id'], $ids)) {
                return $product;
            }
        }

        Log::error('Main product not found');
        return null;
    }

    private function findPriceByCode(array $prices, ?string $defaultCode): array
    {
        if (!$defaultCode) return ['price' => null];

        foreach ($prices as $price) {
            if ($price['default_code'] === $defaultCode) {
                return [
                    'price' => $price['price'] ?? null,
                ];
            }
        }

        return ['price' => null];
    }

    private function extractAttribute(array $product, string $type): ?string
    {
        if (empty($product['product_template_attribute_value_ids'])) return null;

        foreach ($product['product_template_attribute_value_ids'] as $attr) {
            if (stripos($attr['display_name'], $type) !== false) {
                return trim(str_replace(ucfirst($type) . ': ', '', $attr['display_name']));
            }
        }

        return null;
    }

    private function storeImage(?string $url): ?string
    {
        if (empty($url)) {
            Log::info('Image URL is empty');
            return null;
        }

        try {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                Log::error('Invalid image URL: ' . $url);
                return null;
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // فقط للتطوير، أزلها في الإنتاج

            $image = curl_exec($ch);

            if (curl_errno($ch)) {
                Log::error('cURL error: ' . curl_error($ch) . ' URL: ' . $url);
                curl_close($ch);
                return null;
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                Log::error('HTTP error: ' . $httpCode . ' URL: ' . $url);
                return null;
            }

            // بقية الكود كما هو...
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($image);
            $extensions = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/gif' => 'gif',
                'image/webp' => 'webp',
            ];

            $ext = $extensions[$mime] ?? 'jpg';
            $path = 'external_images/' . Str::uuid() . '.' . $ext;

            $stored = Storage::disk('public')->put($path, $image);

            if (!$stored) {
                Log::error('Failed to store image to disk');
                return null;
            }

            return $path;
        } catch (\Exception $e) {
            Log::error('Image storage error: ' . $e->getMessage() . ' URL: ' . $url);
            return null;
        }
    }
}

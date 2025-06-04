<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessExternalProductsImport;
use App\Models\ExternalProduct;
use App\Models\ExternalProductColor;
use App\Models\ExternalProductSize;
use App\Models\ProductShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiProductsController extends Controller
{
    public function index()
    {
        // المسارات
        $productFilePath = base_path('uploads/api_dumps/product_api.json');
        $stockFilePath = base_path('uploads/api_dumps/stock_api.json');
        $priceFilePath = base_path('uploads/api_dumps/price_api.json');

        // تحقق من وجود الملفات
        if (!file_exists($productFilePath) || !file_exists($stockFilePath) || !file_exists($priceFilePath)) {
            return back()->withErrors('أحد الملفات المطلوبة غير موجود.');
        }

        // قراءة الملفات
        $productsContent = file_get_contents($productFilePath);
        $stockContent = file_get_contents($stockFilePath);
        $priceContent = file_get_contents($priceFilePath);

        $products = json_decode($productsContent, true);
        $stocks = json_decode($stockContent, true);
        $prices = json_decode($priceContent, true);

        // تأكد أن البيانات مصفوفة
        if (isset($products['id'])) $products = [$products];
        if (isset($stocks['id'])) $stocks = [$stocks];
        if (isset($prices['id'])) $prices = [$prices];

        // تجهيز بيانات المخزون
        $stockLookup = [];
        foreach ($stocks as $stock) {
            $stockLookup[$stock['id']] = $stock['net_available_qty'] ?? 0;
        }

        // تجهيز بيانات السعر
        $priceLookup = [];
        foreach ($prices as $price) {
            $priceLookup[$price['id']] = $price['price'] . ' ' . ($price['currency'] ?? '');
        }

        // جلب المنتجات المعروضة
        $productShows = ProductShow::pluck('product_id')->toArray();

        // تجميع المنتجات حسب parent_id مع إضافة variants لكل منتج
        $groupedByParent = [];

        foreach ($products as $product) {
            $parentId = $product['parent_id'] ?? $product['id'];
            $productId = $product['id'];

            $stockQty = $stockLookup[$productId] ?? 0;
            $price = $priceLookup[$productId] ?? '';

            if (!isset($groupedByParent[$parentId])) {
                $groupedByParent[$parentId] = [
                    'id' => $parentId,
                    'name' => $product['name'],
                    'default_code' => $product['default_code'] ?? '',
                    'image_url' => $product['image_url'] ?? '',
                    'net_available_qty' => 0,
                    'price' => '',
                    'parent_id' => $product['parent_id'] ?? null,
                    'is_active' => in_array($parentId, $productShows),
                    'variants' => [],
                ];
            }

            // استخراج display_name من product_template_attribute_value_ids
            $attributeDisplayNames = [];
            if (!empty($product['product_template_attribute_value_ids'])) {
                foreach ($product['product_template_attribute_value_ids'] as $attr) {
                    if (isset($attr['display_name'])) {
                        $attributeDisplayNames[] = $attr['display_name'];
                    }
                }
            }

            $groupedByParent[$parentId]['net_available_qty'] += $stockQty;

            if (empty($groupedByParent[$parentId]['price']) && !empty($price)) {
                $groupedByParent[$parentId]['price'] = $price;
            }

            $groupedByParent[$parentId]['variants'][] = [
                'id' => $productId,
                'default_code' => $product['default_code'] ?? '',
                'attributes' => $attributeDisplayNames,
                'net_available_qty' => $stockQty,
                'price' => $price,
                'image_url' => $product['image_url'] ?? '',
            ];
        }


        // فلترة المنتجات التي فيها كمية فقط
        $filteredProducts = array_filter($groupedByParent, function ($item) {
            return $item['net_available_qty'] > 0;
        });

        // فلترة حسب البحث
        $searchTerm = request('q');
        if ($searchTerm) {
            $filteredProducts = array_filter($filteredProducts, function ($product) use ($searchTerm) {
                return stripos($product['name'], $searchTerm) !== false ||
                    stripos($product['default_code'], $searchTerm) !== false ||
                    stripos((string) $product['id'], $searchTerm) !== false;
            });
        }

        // Paginate يدوي
        $currentPage = request()->get('page', 1);
        $perPage = 25;
        $items = collect($filteredProducts)->values();
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        if (request()->ajax()) {
            return view('dashboard.external_product.partials.table', [
                'products' => $paginated
            ])->render();
        }

        return view('dashboard.external_product.index', [
            'products' => $paginated
        ]);
    }

    public function importGroup(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|string'
        ]);

        ProcessExternalProductsImport::dispatch($request->product_ids);

        return redirect()->route('index_external')->with('success', 'جاري استيراد المنتجات في الخلفية...');
    }
    public function update(Request $request, $id)
    {
        $externalProduct = ExternalProduct::with('colors.sizes')->findOrFail($id);

        // ✅ 1. تحديث بيانات المنتج الرئيسي
        $externalProduct->name = $request->input('name');
        $externalProduct->description_sale = $request->input('description_sale');
        $externalProduct->brand = $request->input('brand');
        $externalProduct->default_codes = explode(',', $request->input('default_codes'));
        $externalProduct->price = $request->input('price');


        // ✅ 2. تحديث صورة المنتج الرئيسية
        if ($request->hasFile('image')) {
            $externalProduct->image = $request->file('image')->store('external-products', 'public');
        }

        $externalProduct->save();

        // ✅ 3. تحديث الألوان والأحجام
        $colorsData = $request->input('colors', []);

        $existingColorIds = $externalProduct->colors->pluck('id')->toArray();
        $submittedColorIds = [];

        foreach ($colorsData as $colorIndex => $colorInput) {
            // تحديد إذا اللون جديد أو موجود
            $color = isset($colorInput['id'])
                ? ExternalProductColor::find($colorInput['id'])
                : new ExternalProductColor();

            if (!$color) continue;

            $color->external_product_id = $externalProduct->id;
            $color->name = $colorInput['name'] ?? '';

            // ✅ رفع الصور الجديدة إذا وجدت
            $color->front_image = isset($colorInput['id']) && $request->hasFile("colors.$colorIndex.front_image")
                ? $request->file("colors.$colorIndex.front_image")->store('external-products/colors', 'public')
                : ($color->front_image ?? null);

            $color->back_image = isset($colorInput['id']) && $request->hasFile("colors.$colorIndex.back_image")
                ? $request->file("colors.$colorIndex.back_image")->store('external-products/colors', 'public')
                : ($color->back_image ?? null);

            $color->right_side_image = isset($colorInput['id']) && $request->hasFile("colors.$colorIndex.right_side_image")
                ? $request->file("colors.$colorIndex.right_side_image")->store('external-products/colors', 'public')
                : ($color->right_side_image ?? null);

            $color->left_side_image = isset($colorInput['id']) && $request->hasFile("colors.$colorIndex.left_side_image")
                ? $request->file("colors.$colorIndex.left_side_image")->store('external-products/colors', 'public')
                : ($color->left_side_image ?? null);

            $color->save();

            $submittedColorIds[] = $color->id;

            // ✅ تحديث الأحجام
            $sizes = $colorInput['sizes'] ?? [];
            $existingSizeIds = $color->sizes->pluck('id')->toArray();
            $submittedSizeIds = [];

            foreach ($sizes as $sizeInput) {
                $size = isset($sizeInput['id'])
                    ? ExternalProductSize::find($sizeInput['id'])
                    : new ExternalProductSize();

                if (!$size) continue;

                $size->color_id = $color->id;
                $size->name = $sizeInput['name'] ?? '';
                $size->save();

                $submittedSizeIds[] = $size->id;
            }

            // ✅ حذف الأحجام التي لم تُرسل
            ExternalProductSize::where('color_id', $color->id)
                ->whereNotIn('id', $submittedSizeIds)
                ->delete();
        }

        // ✅ حذف الألوان التي لم تُرسل
        ExternalProductColor::where('external_product_id', $externalProduct->id)
            ->whereNotIn('id', $submittedColorIds)
            ->delete();

        return redirect()->back()->with('success', 'تم تحديث المنتج بنجاح');
    }

    // ===== الدوال المساعدة ===== //

    /**
     * تنظيف اسم السمة من البادئة
     */
    private function cleanAttributeName($displayName, $attributeType)
    {
        $prefix = ucfirst($attributeType) . ': ';
        return trim(str_replace($prefix, '', $displayName));
    }

    /**
     * إضافة حجم للون مع تجنب التكرار
     */
    private function addSizeToColor(&$sizesArray, $sizeName)
    {
        $cleanSize = trim($sizeName);
        if (!empty($cleanSize) && !in_array($cleanSize, $sizesArray)) {
            $sizesArray[] = $cleanSize;
        }
    }

    /**
     * تحميل الصورة وحفظها محلياً
     */
    private function downloadAndStoreImage($imageUrl)
    {
        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return null;
        }

        try {
            $imageContents = file_get_contents($imageUrl);
            if ($imageContents !== false) {
                $extension = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'jpg';
                $fileName = 'external_images/' . Str::random(40) . '.' . $extension;
                Storage::disk('public')->put($fileName, $imageContents);
                return $fileName;
            }
        } catch (\Exception $e) {
            \Log::error('فشل تحميل الصورة: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * حفظ الأحجام للون معين
     */
    private function saveSizesForColor($colorEntry, $sizes)
    {
        if (!empty($sizes)) {
            foreach ($sizes as $size) {
                ExternalProductSize::create([
                    'color_id' => $colorEntry->id,
                    'name' => $size,
                ]);
            }
        } else {
            // إضافة حجم افتراضي إذا لم يكن هناك أحجام
            ExternalProductSize::create([
                'color_id' => $colorEntry->id,
                'name' => 'واحد',
            ]);
        }
    }


    public function show($id)
    {
        // مسارات الملفات
        $productPath = base_path('uploads/api_dumps/product_api.json');
        $stockPath = base_path('uploads/api_dumps/stock_api.json');
        $pricePath = base_path('uploads/api_dumps/price_api.json');

        // التحقق من وجود الملفات
        if (!file_exists($productPath)) {
            abort(404, 'ملف المنتجات غير موجود.');
        }
        if (!file_exists($stockPath)) {
            abort(404, 'ملف المخزون غير موجود.');
        }
        if (!file_exists($pricePath)) {
            abort(404, 'ملف الأسعار غير موجود.');
        }

        // قراءة الملفات
        $products = json_decode(file_get_contents($productPath), true);
        $stocks = json_decode(file_get_contents($stockPath), true);
        $prices = json_decode(file_get_contents($pricePath), true);

        // تحويل إلى مصفوفة إذا كان منتج واحد فقط
        if (isset($products['id'])) {
            $products = [$products];
        }
        if (isset($stocks['id'])) {
            $stocks = [$stocks];
        }
        if (isset($prices['id'])) {
            $prices = [$prices];
        }

        // البحث عن المنتج
        $product = collect($products)->firstWhere('id', (int)$id);

        if (!$product) {
            abort(404, 'المنتج غير موجود.');
        }

        // إضافة معلومات المخزون
        $stockInfo = collect($stocks)->firstWhere('id', (int)$id);
        $product['net_available_qty'] = $stockInfo['net_available_qty'] ?? 0;
        $product['stock_status'] = ($product['net_available_qty'] > 0) ? 'متوفر' : 'غير متوفر';

        // إضافة معلومات السعر
        $priceInfo = collect($prices)->firstWhere('id', (int)$id);
        $product['price'] = $priceInfo['price'] ?? 0;
        $product['currency'] = $priceInfo['currency'];
        $product['discount_price'] = $priceInfo['discount_price'] ?? null;
        $product['has_discount'] = !empty($product['discount_price']);


        return view('dashboard.external_product.show', compact('product'));
    }
    public function toggle($id)
    {
        $existing = ProductShow::where('product_id', $id)->first();

        if ($existing) {
            $existing->delete();
        } else {
            $product =  ProductShow::create(['product_id' => $id]);
        }

        return response()->json([
            'success' => true,
            'is_active' => null
        ]);
    }
    public function index_external()
    {
        $externalProducts = ExternalProduct::with('colors.sizes')->get(); // eager load for performance
        return view('dashboard.external_product.index_external', compact('externalProducts'));
    }
    public function edit($id)
    {
        $externalProduct = ExternalProduct::with(['colors.sizes'])->findOrFail($id);

        return view('dashboard.external_product.edit', compact('externalProduct'));
    }
    public function destroy($id)
    {
        $product = ExternalProduct::findOrFail($id);

        // حذف الصورة من التخزين (إن وجدت)
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        // حذف علاقات الألوان والمقاسات المرتبطة
        $product->colors()->each(function ($color) {
            $color->sizes()->delete(); // حذف المقاسات المرتبطة
            $color->delete();          // حذف اللون
        });

        // حذف المنتج
        $product->delete();

        return redirect()->route('index_external')->with('success', 'تم حذف المنتج بنجاح');
    }
    public function toggleActive(Request $request)
    {
        $product = ExternalProduct::findOrFail($request->id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'status' => true,
            'message' => $product->is_active ? 'تم التفعيل بنجاح' : 'تم التعطيل بنجاح',
        ]);
    }
}

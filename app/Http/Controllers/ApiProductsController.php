<?php

namespace App\Http\Controllers;

use App\Models\ProductShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiProductsController extends Controller
{
    public function index()
    {
        // مسار ملف المنتجات
        $productFilePath = base_path('uploads/api_dumps/product_api.json');
        // مسار ملف المخزون
        $stockFilePath = base_path('uploads/api_dumps/stock_api.json');
        $priceFilePath = base_path('uploads/api_dumps/price_api.json');

        // التحقق من وجود الملفات
        if (!file_exists($productFilePath)) {
            return back()->withErrors('ملف المنتجات غير موجود.');
        }

        if (!file_exists($stockFilePath)) {
            return back()->withErrors('ملف المخزون غير موجود.');
        }
         if (!file_exists($priceFilePath)) {
            return back()->withErrors('ملف الاسعار غير موجود.');
        }

        // قراءة محتوى الملفات
        $productsContent = file_get_contents($productFilePath);
        $stockContent = file_get_contents($stockFilePath);
        $priceContent = file_get_contents($priceFilePath);

        $products = json_decode($productsContent, true);
        $stocks = json_decode($stockContent, true);
        $prices = json_decode($priceContent, true);

        // تحويل إلى مصفوفة إذا كان منتج واحد
        if (isset($products['id'])) {
            $products = [$products];
        }

        if (isset($stocks['id'])) {
            $stocks = [$stocks];
        }
         if (isset($prices['id'])) {
            $prices = [$prices];
        }

        // إنشاء مصفوفة مساعدة للمخزون للبحث السريع
        $stockLookup = [];
        foreach ($stocks as $stock) {
            $stockLookup[$stock['id']] = $stock['net_available_qty'] ?? 0;
        }
        $priceLookup = [];
        foreach($prices as $price){
            $priceLookup[$price['id']]= $price['price'] . ' ' . $price['currency'] ?? 0;
        }

        // الحصول على المنتجات المعروضة
        $productShows = ProductShow::pluck('product_id')->toArray();

        // دمج بيانات المنتج مع المخزون وتصفية المنتجات التي لديها مخزون > 0
        $filteredProducts = [];
        foreach ($products as $product) {
            $stockQty = $stockLookup[$product['id']] ?? 0;
            $pri = $priceLookup[$product['id']] ?? 0;

            if ($stockQty > 0) {
                $product['is_active'] = in_array($product['id'], $productShows);
                $product['net_available_qty'] = $stockQty;
                $product['price'] = $pri;
                $filteredProducts[] = $product;
            }
        }

        // عمل paginate يدوي للـ array المصفاة
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $items = collect($filteredProducts);
        $paginated = new LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('dashboard.external_product.index', [
            'products' => $paginated
        ]);
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
    $product['currency'] = $priceInfo['currency'] ;
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
  use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ProductShow;

class ExternalProductController extends BaseController
{
 
public function visibleProducts(Request $request)
{
    $filePath = base_path('uploads/api_dumps/product_api.json');

    if (!file_exists($filePath)) {
        return response()->json(['error' => 'ملف البيانات غير موجود.'], 404);
    }

    $jsonContent = file_get_contents($filePath);
    $products = json_decode($jsonContent, true);

    // تأكد أنها مصفوفة
    if (isset($products['id'])) {
        $products = [$products];
    }

    // جلب الـ ids من جدول product_shows
    $visibleProductIds = ProductShow::pluck('product_id')->toArray();

    // فلترة المنتجات
    $filteredProducts = collect($products)->filter(function ($product) use ($visibleProductIds) {
        return in_array($product['id'], $visibleProductIds);
    })->values();

    // Pagination يدوي
    $currentPage = $request->get('page', 1);
    $perPage = 10;

    $paginated = new LengthAwarePaginator(
        $filteredProducts->forPage($currentPage, $perPage),
        $filteredProducts->count(),
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

           return $this->sendResponse($filteredProducts, "SUCCESS");

}

}

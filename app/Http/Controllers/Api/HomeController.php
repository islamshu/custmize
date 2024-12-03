<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerRessours;
use App\Http\Resources\DiscountCodeResourse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductShortDataResourse;
use App\Http\Resources\ProductResourse;
use App\Models\Banner;
use App\Models\DiscountCode;
use App\Models\Product;

class HomeController extends BaseController
{
    public function home()
    {
        $banners = BannerRessours::collection(Banner::get());
        $products = ProductShortDataResourse::collection(Product::get());

        $data = [
            'banners' => $banners,
            'products' => $products,
        ];

        return $this->sendResponse($data, "SUCCESS");
    }
    public function products()
    {
        $products = Product::get();
        $products = ProductShortDataResourse::collection($products);
        return $this->sendResponse($products, "SUCCESS");
    }
    public function all_promocods()
    {
        $products = DiscountCode::get();
        $products = DiscountCodeResourse::collection($products);
        return $this->sendResponse($products, "SUCCESS");
    }
    
    public function single_product($slug)
    {
        $product = Product::where("slug", $slug)->first();
        $product = new ProductResourse($product);
        return $this->sendResponse($product, "SUCCESS");
    }
    public function size_calculate()
    {
        $res = [
            'persantige' => '0.' . get_general_value('percentage'),
            'factor' => get_general_value('threshold'),
            'if_output_is_less_factor' => get_general_value('price_less'),
            'if_output_is_equal_factor' => get_general_value('price_equal'),
            'if_output_is_greater_factor' => get_general_value('price_greater'),
        ];
        return $this->sendResponse($res, 'success');
    }
    public function example_size_calculate(Request $request)
{
    // الحصول على القيم من الطلب
    $hight = $request->hight;
    $width = $request->width;

    // التحقق من صحة المدخلات
    if (!$hight || !$width) {
        return $this->sendError('Invalid input. Please provide hight and width.');
    }

    // الحصول على القيم العامة (النسبة والعوامل والأسعار)
    $percentage =  get_general_value('percentage');
    $threshold = get_general_value('threshold');
    $priceLess = get_general_value('price_less');
    $priceEqual = get_general_value('price_equal');
    $priceGreater = get_general_value('price_greater');

    // حساب الناتج
    $result = $hight * $width * $percentage;

    // تطبيق الشرط بناءً على الناتج
    $comparison = '';
    $price = 0;

    if ($result < $threshold) {
        $comparison = "Result is less than the threshold.";
        $price = $priceLess;
    } elseif ($result == $threshold) {
        $comparison = "Result is equal to the threshold.";
        $price = $priceEqual;
    } else {
        $comparison = "Result is greater than the threshold.";
        $price = $priceGreater;
    }

    // إعداد الاستجابة
    $response = [
        'input' => [
            'hight' => $hight,
            'width' => $width,
            'percentage' => $percentage,
        ],
        'result' => $result,
        'comparison' => $comparison,
        'price' => $price,
    ];

    // إرجاع الاستجابة
    return $this->sendResponse($response, 'Calculation successful');
}

}

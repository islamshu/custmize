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
use App\Services\UnsplashService;

class HomeController extends BaseController
{
    // {
    //     "cart": {
    //         "orders": [
    //             {
    //                 "product_id": "12345",
    //                 "color": "Red",
    //                 "size": "L",
    //                 "quantity": 2,
    //                 "front_image":"image_url",
    //                 "back_image":"image_url",
    //                 "logos": [
    //                     "logo1.png",
    //                     "logo2.png"
    //                 ],
    //                 "price_without_size_color_price":20,
    //                 "price_for_size_color_price":29.99,
    //                 "full_price": 49.99
    //             },
    //             {
    //                  "product_id": "12345",
    //                 "color": "Red",
    //                 "size": "L",
    //                 "quantity": 2,
    //                 "front_image":"image_url",
    //                 "back_image":"image_url",
    //                 "logos": [
    //                     "logo1.png",
    //                     "logo2.png"
    //                 ],
    //                 "price_without_size_color_price":10, 
    //                 "price_for_size_color_price":7, 
    //                 "full_price": 17 
    //             }
    //         ],
    //       "full_price_befor_discount":"66.99",
    //       "promocode":"2155656",
    //       "discount":"5",
    //       "full_code_after_discout":61.99,
    //       "
    //     }
    // }
    
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
            'persantige' =>  get_general_value('percentage'),
            'factor' => get_general_value('threshold'),
            'if_output_is_less_factor' => get_general_value('price_less'),
            'if_output_is_equal_factor' => get_general_value('price_equal'),
            // 'if_output_is_greater_factor' => get_general_value('price_greater'),
        ];
        return $this->sendResponse($res, 'success');
    }
    public function size_calculate_new(Request $request)
    {
        $width = $request->query('width');
        $height = $request->query('height');

        $area = $height * $width;
        $price = 0;
        // تطبيق الشروط
        if ($area <= 3) {
            $price = 3;
        } elseif ($area <= 8) {
            $price = 4;
        } elseif ($area <= 15) {
            $price = 6;
        } elseif ($area <= 21) {
            $price = 8;
        } elseif ($area <= 30) {
            $price = 10;
        } else {
            $price = "خارج النطاق المحدد";
        }
        return $this->sendResponse($price, 'success');
    }
    public function images(Request $request,UnsplashService $unsplashService )
    {
        $query = request('query',$request->search); // Default keyword: "addidas logo"
        $images = $unsplashService->searchImages($query);
    
        // Extract only the 'urls' field from each image
        $imageUrls = array_map(function($image) {
            return $image['urls']['thumb'];
        }, $images['results']);
        return $this->sendResponse($imageUrls,'all brands');
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
    // $priceGreater = get_general_value('price_greater');

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
        $price = $result;
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

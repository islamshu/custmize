<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerRessours;
use App\Http\Resources\DiscountCodeResourse;
use App\Http\Resources\OrderResourse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductShortDataResourse;
use App\Http\Resources\ProductResourse;
use App\Models\Banner;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Services\UnsplashService;
use App\Services\BrandfetchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
    public function all_orders()
    {
        $clinet = auth('api')->user();
        $orders = Order::where('client_id', $clinet->id)->where('status', 'completed')->get();
        $orders = OrderResourse::collection($orders);
        return $this->sendResponse($orders, "all orders");
    }
    public function track_order(Request $request)
    {
        $clinet = auth('api')->user();
        $order = Order::where('code', $request->code)->first();
        $order = new OrderResourse($order);
        return $this->sendResponse($order, "my order");
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
    public function size_calculate_new_factor()
{
    // Get general values (you can customize these based on your need)
    $priceLessEqual3 = get_general_value('price_less_equal_3');
    $price3To8 = get_general_value('price_3_to_8');
    $price8To15 = get_general_value('price_8_to_15');
    $price15To21 = get_general_value('price_15_to_21');
    $price21To30 = get_general_value('price_21_to_30');
    $priceGreater30 = get_general_value('price_greater_30');

    // You can calculate the area from length and width here as well
    $length = request('length', 0);  // You can also validate this input
    $width = request('width', 0);    // Same for width
    $area = $length * $width;

    // Determine the appropriate price based on the area
    if ($area <= 3) {
        $price = $priceLessEqual3;
    } elseif ($area > 3 && $area <= 8) {
        $price = $price3To8;
    } elseif ($area > 8 && $area <= 15) {
        $price = $price8To15;
    } elseif ($area > 15 && $area <= 21) {
        $price = $price15To21;
    } elseif ($area > 21 && $area <= 30) {
        $price = $price21To30;
    } else {
        // For area > 30, use the calculated area for price
        $price = $area; // This can be adjusted if needed
    }

    // Prepare response
    $res = [
        // 'area' => $area,
        // 'price' => $price,
        // 'length' => $length,
        // 'width' => $width,
        'price_less_equal_3' => $priceLessEqual3,
        'price_3_to_8' => $price3To8,
        'price_8_to_15' => $price8To15,
        'price_15_to_21' => $price15To21,
        'price_21_to_30' => $price21To30,
        'price_greater_30' => 'width * length',
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
            $price = $area;
        }
        return $this->sendResponse($price, 'success');
    }
    public function images(Request $request, BrandfetchService $brandfetch)
{
    // Get name from request or set default
    $name = $request->search.'.com';
    
    // Get clientId from config or env
    $clientId = config('services.brandfetch.client_id');

    try {
        $response = Http::get("https://api.brandfetch.io/v2/search/{$name}", [
            'c' => $clientId
        ]);

        if ($response->successful()) {
            $icons = array_map(function($brand) {
                return $brand['icon'];
            }, $response->json());
            return $this->sendResponse($icons,'success');
        }
        return $this->sendError('Failed to fetch data');

        return response()->json([
            'error' => 'Failed to fetch data'
        ], 400);

    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}
    public function images_old(Request $request, UnsplashService $unsplashService)
    {

        $query = request('query', $request->search); // Default keyword: "addidas logo"
        $images = $unsplashService->searchImages($query);

        // Extract only the 'urls' field from each image
        $imageUrls = array_map(function ($image) {
            return $image['urls']['thumb'];
        }, $images['results']);

        return $this->sendResponse($imageUrls, 'all brands');
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

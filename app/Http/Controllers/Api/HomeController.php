<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerRessours;
use Illuminate\Http\Request;
use App\Http\Resources\ProductShortDataResourse;
use App\Http\Resources\ProductResourse;
use App\Models\Banner;
use App\Models\Product;

class HomeController extends BaseController
{
    public function home(){
        $banners = BannerRessours::collection(Banner::get());
        $products = ProductShortDataResourse::collection(Product::get());
        
        $data = [
            'banners' => $banners,
            'products' => $products,
        ];
        
        return $this->sendResponse($data, "SUCCESS");

    }
    public function products(){
        $products = Product::get();
        $products = ProductShortDataResourse::collection($products);
        return $this->sendResponse($products,"SUCCESS");
    }
    public function single_product($slug){
        $product = Product::where("slug", $slug)->first();
        $product = new ProductResourse($product);
        return $this->sendResponse($product,"SUCCESS");
    }

    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductShortDataResourse;
use App\Http\Resources\ProductResourse;

use App\Models\Product;

class HomeController extends BaseController
{
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

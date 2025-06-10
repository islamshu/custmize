<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExternalProductResource;
use App\Http\Resources\ExternalSizeResource;
use App\Models\ExternalProduct;
use App\Models\Product;
use Illuminate\Http\Request;
  use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\ProductShow;

class ExternalProductController extends BaseController
{
 
public function visibleProducts(Request $request)
{
     $products = ExternalProduct::where('is_active',1)->get();
        $products = ExternalProductResource::collection($products);
        return $this->sendResponse($products, "SUCCESS");
}

}

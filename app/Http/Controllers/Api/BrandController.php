<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    protected $brandfetch;

    public function __construct(BrandfetchService $brandfetch)
    {
        $this->brandfetch = $brandfetch;
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UnsplashService
{
    protected $apiUrl = 'https://api.unsplash.com/';
    protected $accessKey;

    public function __construct()
    {
        $this->accessKey = env('UNSPLASH_ACCESS_KEY');
    }

    public function searchImages($query, $perPage = 10)
    {
        $response = Http::get($this->apiUrl . 'search/photos', [
            'query' => $query,
            'per_page' => $perPage,
            'client_id' => $this->accessKey,
        ]);

        return $response->json();
    }
}

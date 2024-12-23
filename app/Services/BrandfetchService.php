<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BrandfetchService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.brandfetch.io/v2/brands/';

    public function __construct()
    {
        // Get API key from Laravel config
        $this->apiKey = config('services.brandfetch.key');
    }

    // Main method to get all brand assets
    public function getBrandAssets($domain)
    {
        // Check if data exists in cache
        $cacheKey = 'brandfetch_' . $domain;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // Make API request
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->get($this->baseUrl . $domain);

            if ($response->successful()) {
                $data = $response->json();
                // Cache for 24 hours
                Cache::put($cacheKey, $data, now()->addHours(24));
                return $data;
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Brandfetch API Error: ' . $e->getMessage());
            return null;
        }
    }

    // Helper method to get just the logo
    public function getLogo($domain)
    {
        $assets = $this->getBrandAssets($domain);
        
        if (!$assets || empty($assets['logos'])) {
            return null;
        }

        // Find first PNG or SVG logo
        foreach ($assets['logos'] as $logo) {
            if (isset($logo['formats'])) {
                foreach ($logo['formats'] as $format) {
                    if (in_array($format['format'], ['png', 'svg'])) {
                        return $format['src'];
                    }
                }
            }
        }

        return null;
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductUserService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.management_api.url', 'https://management.villahoteldieng.com/api');
        $this->apiKey = config('services.management_api.key');
    }

    /**
     * Get connected users for a specific product
     *
     * @param int $productId
     * @return array|null
     */
    public function getProductUsers($productId)
    {
        $cacheKey = "product_users_{$productId}";
        $cacheTtl = 3600; // 1 hour

        return Cache::remember($cacheKey, $cacheTtl, function () use ($productId) {
            try {
                $response = Http::timeout(10)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Authorization' => $this->apiKey ? "Bearer {$this->apiKey}" : null,
                    ])
                    ->get("{$this->baseUrl}/products/{$productId}/users");

                if ($response->successful()) {
                    $data = $response->json();

                    // Validate response structure
                    if (isset($data['connected_users']) && is_array($data['connected_users'])) {
                        return $data['connected_users'];
                    }

                    Log::warning('Invalid API response structure for product users', [
                        'product_id' => $productId,
                        'response' => $data
                    ]);

                    return [];
                }

                Log::error('Failed to fetch product users from API', [
                    'product_id' => $productId,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [];

            } catch (\Exception $e) {
                Log::error('Exception while fetching product users', [
                    'product_id' => $productId,
                    'error' => $e->getMessage()
                ]);

                return [];
            }
        });
    }

    /**
     * Get admin emails for a specific product
     *
     * @param int $productId
     * @return array
     */
    public function getProductAdminEmails($productId)
    {
        $users = $this->getProductUsers($productId);

        $adminEmails = [];
        foreach ($users as $user) {
            if (isset($user['email']) && isset($user['roles']) && is_array($user['roles'])) {
                // Include users with admin or developer roles
                if (in_array('admin', $user['roles']) || in_array('developer', $user['roles'])) {
                    $adminEmails[] = $user['email'];
                }
            }
        }

        return array_unique($adminEmails);
    }

    /**
     * Clear cache for specific product
     *
     * @param int $productId
     * @return void
     */
    public function clearProductCache($productId)
    {
        Cache::forget("product_users_{$productId}");
    }
}
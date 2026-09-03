<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\ProductVerification;
use App\Models\SiteSetting;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ApiController extends Controller
{
    /**
     * GET /api/v1/products
     */
    public function products(Request $request)
    {
        try {
            $limit = min($request->get('limit', 15), 50);
            $query = Product::with(['category', 'images'])->where('is_active', true);

            if ($request->filled('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($request->filled('category')) {
                $catSlug = $request->get('category');
                $cat = Category::where('slug', $catSlug)->first();
                if ($cat) {
                    $query->where('category_id', $cat->id);
                }
            }

            $products = $query->latest()->paginate($limit);

            return response()->json([
                'status' => 'success',
                'count' => $products->total(),
                'data' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'total' => $products->total(),
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/products/{slug}
     */
    public function productDetail($slug)
    {
        try {
            $product = Product::with(['category', 'images', 'verifications'])
                ->where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();

            return response()->json([
                'status' => 'success',
                'data' => $product
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
        }
    }

    /**
     * GET /api/v1/categories
     */
    public function categories()
    {
        try {
            $categories = Category::whereNull('parent_id')
                ->with(['children' => function($q) {
                    $q->orderBy('order', 'asc');
                }])
                ->orderBy('order', 'asc')
                ->get();

            return response()->json([
                'status' => 'success',
                'count' => $categories->count(),
                'data' => $categories
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/categories/{slug}
     */
    public function categoryDetail(Request $request, $slug)
    {
        try {
            $category = Category::where('slug', $slug)->with('children')->firstOrFail();
            $categoryIds = array_merge([$category->id], $category->children->pluck('id')->toArray());

            $products = Product::with(['category', 'images'])
                ->whereIn('category_id', $categoryIds)
                ->where('is_active', true)
                ->paginate(12);

            return response()->json([
                'status' => 'success',
                'category' => $category,
                'products' => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'total' => $products->total(),
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);
        }
    }

    /**
     * POST /api/v1/verify-code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'security_code' => 'required|string',
        ]);

        $code = trim($request->input('security_code'));

        try {
            $verification = ProductVerification::with('product.category')
                ->where('security_code', $code)
                ->first();

            if (!$verification) {
                return response()->json([
                    'status' => 'invalid',
                    'authentic' => false,
                    'message' => 'WARNING: The security code entered could not be verified in our master database. This product may be COUNTERFEIT.',
                    'code' => $code,
                ], 404);
            }

            if ($verification->is_verified) {
                return response()->json([
                    'status' => 'previously_verified',
                    'authentic' => true,
                    'message' => 'ATTENTION: This security code was previously verified.',
                    'code' => $verification->security_code,
                    'batch_number' => $verification->batch_number,
                    'verified_at' => $verification->verified_at ? $verification->verified_at->toIso8601String() : null,
                    'product' => $verification->product ? $verification->product->name : null,
                ]);
            }

            $verification->update([
                'is_verified' => true,
                'verified_at' => now(),
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'status' => 'authentic',
                'authentic' => true,
                'message' => 'AUTHENTIC PRODUCT CONFIRMED! Thank you for purchasing genuine Zerox Pharmaceuticals product.',
                'code' => $verification->security_code,
                'batch_number' => $verification->batch_number,
                'verified_at' => now()->toIso8601String(),
                'product' => $verification->product ? $verification->product->name : null,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/banners
     */
    public function banners()
    {
        try {
            $banners = Banner::where('is_active', true)->orderBy('order', 'asc')->get();
            return response()->json([
                'status' => 'success',
                'count' => $banners->count(),
                'data' => $banners
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/settings
     */
    public function settings()
    {
        try {
            $settings = [
                'site_name' => SiteSetting::get('site_name', 'Zerox Pharmaceuticals'),
                'company_name' => SiteSetting::get('company_name', 'Zerox Pharmaceuticals Ltd'),
                'contact_email' => SiteSetting::get('contact_email', 'support@zzerox.com'),
                'contact_phone' => SiteSetting::get('contact_phone', '+91 11 27023256'),
                'company_address' => SiteSetting::get('company_address', 'Plot No. 42, Industrial Area Phase II, New Delhi, India'),
                'map_latitude' => SiteSetting::get('map_latitude', '28.535516'),
                'map_longitude' => SiteSetting::get('map_longitude', '77.261021'),
                'map_zoom' => SiteSetting::get('map_zoom', '14'),
                'site_logo_header' => asset(SiteSetting::get('site_logo_header', 'img/logo.png')),
                'site_logo_footer' => asset(SiteSetting::get('site_logo_footer', 'img/logo.png')),
                'site_favicon' => asset(SiteSetting::get('site_favicon', 'img/favicon.png')),
            ];

            return response()->json([
                'status' => 'success',
                'data' => $settings
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /api/v1/subscribe
     */
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        try {
            $sub = Subscriber::firstOrCreate(['email' => strtolower(trim($request->email))], [
                'ip_address' => $request->ip(),
                'is_active' => true,
                'subscribed_at' => now(),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Subscribed successfully to Zerox official updates.',
                'data' => $sub
            ]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * GET /api/v1/health
     */
    public function health()
    {
        $start = microtime(true);
        $dbOk = false;
        try {
            DB::select('SELECT 1');
            $dbOk = true;
        } catch (\Throwable $e) {}

        return response()->json([
            'status' => 'ok',
            'environment' => config('app.env'),
            'database' => $dbOk ? 'connected' : 'disconnected',
            'latency_ms' => round((microtime(true) - $start) * 1000, 2),
            'memory_peak_mb' => round(memory_get_peak_usage(true) / 1024 / 1024, 2),
            'timestamp' => now()->toIso8601String(),
        ]);
    }

    /**
     * GET /api/v1/openapi.json
     */
    public function openApiSpec()
    {
        $baseUrl = url('/api/v1');
        $spec = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Zerox Pharmaceuticals REST API',
                'description' => 'Official REST API Documentation and Interactive Playground for Zerox Pharmaceuticals Catalog, Verifications, Categories, and Settings.',
                'version' => '1.0.0',
                'contact' => [
                    'name' => 'Zerox Developer Support',
                    'email' => 'support@zzerox.com',
                    'url' => 'https://zzerox.com'
                ]
            ],
            'servers' => [
                ['url' => $baseUrl, 'description' => 'Current API Endpoint']
            ],
            'paths' => [
                '/products' => [
                    'get' => [
                        'summary' => 'List Products Catalog',
                        'description' => 'Fetch list of active products with pagination and search/category filters.',
                        'parameters' => [
                            ['name' => 'search', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string'], 'description' => 'Filter by product name or SKU'],
                            ['name' => 'category', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'string'], 'description' => 'Filter by category slug'],
                            ['name' => 'limit', 'in' => 'query', 'required' => false, 'schema' => ['type' => 'integer', 'default' => 15], 'description' => 'Records per page']
                        ],
                        'responses' => [
                            '200' => ['description' => 'Successful products list response']
                        ]
                    ]
                ],
                '/products/{slug}' => [
                    'get' => [
                        'summary' => 'Get Single Product Details',
                        'parameters' => [
                            ['name' => 'slug', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string'], 'description' => 'Product URL slug']
                        ],
                        'responses' => [
                            '200' => ['description' => 'Product details'],
                            '404' => ['description' => 'Product not found']
                        ]
                    ]
                ],
                '/categories' => [
                    'get' => [
                        'summary' => 'List Category Tree',
                        'responses' => [
                            '200' => ['description' => 'Category tree list']
                        ]
                    ]
                ],
                '/categories/{slug}' => [
                    'get' => [
                        'summary' => 'Get Category Details with Paginated Products',
                        'parameters' => [
                            ['name' => 'slug', 'in' => 'path', 'required' => true, 'schema' => ['type' => 'string'], 'description' => 'Category URL slug']
                        ],
                        'responses' => [
                            '200' => ['description' => 'Category with products list']
                        ]
                    ]
                ],
                '/verify-code' => [
                    'post' => [
                        'summary' => 'Verify Packaging Scratch Code',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['security_code'],
                                        'properties' => [
                                            'security_code' => ['type' => 'string', 'example' => 'ZX99887766']
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Code verified or previously used'],
                            '404' => ['description' => 'Invalid or counterfeit security code']
                        ]
                    ]
                ],
                '/banners' => [
                    'get' => [
                        'summary' => 'List Active Hero Banners',
                        'responses' => [
                            '200' => ['description' => 'Active banners list']
                        ]
                    ]
                ],
                '/settings' => [
                    'get' => [
                        'summary' => 'Get Public Site Settings & Map Coordinates',
                        'responses' => [
                            '200' => ['description' => 'Public settings']
                        ]
                    ]
                ],
                '/subscribe' => [
                    'post' => [
                        'summary' => 'Subscribe to Newsletter',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['email'],
                                        'properties' => [
                                            'email' => ['type' => 'string', 'example' => 'user@example.com']
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Subscription confirmed']
                        ]
                    ]
                ],
                '/health' => [
                    'get' => [
                        'summary' => 'Get System Health & DB Response Time',
                        'responses' => [
                            '200' => ['description' => 'System health status']
                        ]
                    ]
                ],
            ]
        ];

        return response()->json($spec);
    }
}
